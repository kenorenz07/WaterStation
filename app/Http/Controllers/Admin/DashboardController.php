<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStatistics($year) 
    {
        if(!$year) $year = Carbon::now()->year;
        
        $sales = [];

        for($i = 1;$i <= 12;$i++){
            $sales[] = Sale::whereYear('created_at',$year)->whereMonth('created_at', $i)->count();
        }

        return [
            'customers' => User::all()->count(),
            'products' => Product::all()->count(),
            'orders' => Order::whereMonth('created_at', Carbon::now()->month)->count(),
            'sales' => $sales
        ];
    }
}
