<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;
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

        return [
            "orders" =>$index->paginate(10),
            "grandtotal" => round($index->sum('total'), 2)
        ];
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

      // Generate PDF
    public function createPDF($start,$end,$status) 
    {

        $index = Order::query();
        
        if($status!="all"){
            $index->where("status" ,$status);
        }

        $index->whereBetween("created_at", [$start, $end])
        ->orderBy("created_at", 'desc');
        
        // retreive all records from db
        $data = ['orders' => $index->get(),"grandtotal" => round($index->sum('total'), 2)];
  
        // share data to view;
        $pdf = PDF::loadView('order_reports', $data)->setPaper('a4', 'landscape');
  
        // download PDF file with download method
        return $pdf->download('ORDERREPORT'.$start.'-'.$end.'.pdf');
    }
}
