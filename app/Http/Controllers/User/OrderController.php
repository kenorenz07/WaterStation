<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user = $request->user();
        $total = 0;
        $cart_ids = Arr::pluck($request->orders, 'id');

        foreach($request->orders as $product){
            $total += $product["product"]["price"] * $product["quantity"];
        }

        Cart::destroy($cart_ids);

        return Order::create([
            'user_id' => $user->id,
            'orders' => json_encode($request->orders),
            'total' => $total,
            'status' => 'pending',
        ]);

    }
}
