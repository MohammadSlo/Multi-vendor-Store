<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {

        return 'this is products index';
    }

    public function show(Product $product)
    {

        if (! $product->status) {
            abort(404);
        }

        return view('front.products.show', compact('product'));
    }
}
