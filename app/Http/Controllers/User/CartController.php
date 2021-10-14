<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->carts;
    }

    public function addProductToCart(Product $product,Request $request)
    {
        return $request->user()->carts()->create([
            'product_id' => $product->id,
            'total_price' => $product->price * $request->quantity,
            'quantity' => $request->quantity
        ]);
    }

    public function updateProductQuantity(Cart $cart,Request $request)
    {
        return $cart->update([
            'total_price' => $cart->product->price * $request->quantity,
            'quantity' => $request->quantity
        ]);
    }

    public function removeProductToCart(Cart $cart)
    {
        return $cart->delete();
    }




}
