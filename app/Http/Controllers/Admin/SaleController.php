<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use PDF;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $index = Sale::query();
        
        if($request->query('date_filter')){
            $index->whereDate("created_at" ,$request->query('date_filter'));
        }
        $index->orderBy('created_at', 'desc');

        // return $index->paginate(10);
        
        return [
            "sales" =>$index->paginate(10),
            "grandtotal" => round($index->sum('total'), 2)
        ];
    }

    public function createPDF($start,$end) 
    {

        $index = Sale::query();

        $index->whereBetween("created_at", [$start, $end])
        ->orderBy("created_at", 'desc');
        
        // retreive all records from db
        $data = ['sales' => $index->get(),"grandtotal" => round($index->sum('total'), 2)];
  
        // share data to view;
        $pdf = PDF::loadView('sale_reports', $data)->setPaper('a4', 'landscape');
  
        // download PDF file with download method
        return $pdf->download('SALESREPORT'.$start.'-'.$end.'.pdf');
    }
}
