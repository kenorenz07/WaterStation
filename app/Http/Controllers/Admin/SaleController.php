<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\Sale;
use Illuminate\Http\Request;
use PDF;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $index = Sale::query();
        
        $delivery_men = json_decode($request->query('filter_delivery_men'));
            
        $index->whereIn('delivery_man_id',$delivery_men);
        
        if($request->query('date_filter')){
            $index->whereDate("created_at" ,$request->query('date_filter'));
        }
        $index->orderBy('created_at', 'desc');

        // return $index->paginate(10);
        
        return [
            "sales" =>$index->paginate($request->query('per_page')),
            "grandtotal" => round($index->sum('total'), 2)
        ];
    }

    public function createPDF($start,$end,$delivery_men) 
    {
        $delivery_men = json_decode($delivery_men);
        
        $index = Sale::whereIn('delivery_man_id',$delivery_men)->whereBetween("created_at", [$start, $end])
        ->orderBy("created_at", 'desc')->get();

        
        // retreive all records from db
        $data = ['sales' => $index,"grandtotal" => round($index->sum('total'), 2)];
        if(count($delivery_men) <= 5){
            $names = DeliveryMan::whereIn('id',$delivery_men)->pluck('name');
            $data['delivery_names'] =  implode(' ,',$names->toArray());
        }
  
        // share data to view;
        $pdf = PDF::loadView('sale_reports', $data)->setPaper('a4', 'landscape');
  
        // download PDF file with download method
        return $pdf->download('DELSALESREPORT'.$start.'-'.$end.'.pdf');
    }
}
