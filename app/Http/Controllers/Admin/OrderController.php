<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $index = Order::query();
        
        if($request->query('status_filter')!="all"){
            $index->where("status" ,$request->query('status_filter'));
        }
        else {
            $index->where('status', '!=' , "denied");
        }

        if($request->query('date_filter')){
            $index->whereDate("created_at" ,$request->query('date_filter'));
        }
        $index->orderBy('created_at', 'desc');

        return $index->paginate(10);
    }

    public function updateStatus(Order $order,Request $request)
    {
        return $order->update([
            "status" => $request->status
        ]);
    }

    public function updateDeliveryMan(Order $order,Request $request)
    {
        return $order->update([
            "status" => "assigned-to-driver",
            "delivery_man_id" => $request->delivery_man
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