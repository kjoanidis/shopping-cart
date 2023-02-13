<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\PackageCollection;
use App\Http\Resources\PackageResource;
use App\Models\Product;
use App\Models\Package;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): PackageCollection
    {
        return new PackageCollection(Package::all());
    }

    /**
     * Display the specified resource.
     *
     * @param Sku $package
     * @return PackageResource
     */
    public function show(Sku $package): PackageResource
    {
        return new PackageResource($package);
    }
}
