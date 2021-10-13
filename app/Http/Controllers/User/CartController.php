<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(User $user)
    {
        return $user->carts;
    }

    public function addProductToCart(User $user,Product $product,Request $request)
    {
        return $user->carts()->create([
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
