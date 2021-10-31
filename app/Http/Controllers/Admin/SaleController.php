<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $index = Sale::query()->with('user','delivery_man');
        
        if($request->query('date_filter')){
            $index->whereDate("created_at" ,$request->query('date_filter'));
        }
        $index->orderBy('created_at', 'desc');

        return $index->paginate(10);
    }
}
