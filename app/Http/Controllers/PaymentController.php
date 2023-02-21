<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sku;
use App\Models\Order;
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


            foreach($products as $key => $product) {

                $item = Sku::find($product['id']);
                $stripe_price_id = $item->stripe_price_id;
                $subscription_name = $item->name;
                $quantity = $product['quantity'];


                if($item->is_subscription) {
                    $subscription = $user->newSubscription($subscription_name, $stripe_price_id)
                        ->quantity($quantity)
                        ->create($request->input('payment_method_id'),[],[
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
                        $request->input('payment_method_id')
                    );
                    $payment_id = $payment->id;
                }


                // Transaction History
                $purchase_record = [
                    'transaction_id' => $payment_id,
                    'user_id' => $user->id,
                    'sku_id' => $product['id'],
                    'total' => $item->price * $quantity,
                    'price' => $item->price,
                    'quantity' => $quantity,
                    'status' => 'Success',
                    'last_four' => $user->pm_last_four,
                    'card_type' => ucwords($user->pm_type),
                ];

                $order = new Order();
                $order->create($purchase_record);

                return response()->json(['message' => "success"], 200);

            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
