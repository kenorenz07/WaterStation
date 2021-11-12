<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAll(Request $request)
    {
        return $request->user()->orders;
    }
    public function updateStatus(Order $order,Request $request)
    {
        return $order->update([
            "status" => $request->status
        ]);
    }
    public function updateDateTimeDeliver(Order $order,Request $request)
    {
        return $order->update([
            "date_to_deliver" => $request->date_filter,
            "time_to_deliver" => $request->time_filter,
        ]);
    }
}
