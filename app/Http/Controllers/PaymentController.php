<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sku;
use App\Models\Order;
use App\Models\OrderSku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $request)
    {

        $user = User::firstOrCreate(
            [
                'email' => $request->input('email')
            ],
            [
                'password' => Str::random(12),
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code')
            ]
        );

        try {

            $products = json_decode($request->input('cart'), true);
            $shipping_amount = $request->input('delivery_method') === "Standard" ? 500 : 1600;
            $payment_method_id = $request->input('payment_method_id');


            // Transaction History
            $order_recoard = [
                'user_id' => $user->id,
                'total' => $request->input('total_amount'),
                // 'last_four' => $user->pm_last_four,
                // 'card_type' => $user->pm_type,
            ];

            $order = new Order();
            $order_id = $order->create($order_recoard)->id;

            foreach($products as $key => $product) {

                $item = Sku::find($product['id']);
                $stripe_price_id = $item->stripe_price_id;
                $subscription_name = $item->name;
                $quantity = $product['quantity'];


                if($item->is_subscription) {
                    $subscription = $user->newSubscription($subscription_name, $stripe_price_id)
                        ->quantity($quantity)
                        ->create($payment_method_id,[],[
                            'payment_behavior' => 'error_if_incomplete',
                    ]);
                    $payment_id = $subscription->latestPayment()->id;
                } else {

                    // if you want to use products in stripe
                    // $result = $user->invoicePrice($stripe_price_id,  $quantity);
                    // $payment_id = $result->payment_intent;

                    // if you want to use products in local DB
                    $payment = $user->charge(
                        100 * $item->price * $quantity,
                        $payment_method_id,
                        [
                            'setup_future_usage'=> 'off_session'
                        ]
                    );
                    $payment_id = $payment->id;
                }

                // Transaction History

                $order_sku_record = [
                    'payment_id' => $payment_id,//transaction_id
                    'order_id' => $order_id,
                    'sku_id' => $product['id'],
                    'quantity' => $quantity,
                    'status' => 'Success',
                ];

                $order = new OrderSku();
                $order->create($order_sku_record);
            }


            // Shipping amount

            $payment = $user->charge(
                $shipping_amount,
                $payment_method_id,
                [
                    'setup_future_usage'=> 'off_session'
                ]
            );
            $payment_id = $payment->id;

            // Transaction History
            $order_sku_record = [
                'payment_id' => $payment_id,
                'order_id' => $order_id,
                'sku_id' => 0,
                'quantity' => $quantity,
                'status' => 'Success',
            ];

            $order = new OrderSku();
            $order->create($order_sku_record);


            return response()->json(['message' => "success"], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
