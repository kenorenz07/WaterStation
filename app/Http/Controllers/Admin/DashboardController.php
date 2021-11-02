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
        
        $months = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        $sales = [];

        foreach($months as $month){
            $sales[] = Sale::query()->whereYear('created_at',$year)->whereMonth('created_at',$month)->count();
        }

        return [
            'customers' => User::all()->count(),
            'products' => Product::all()->count(),
            'orders' => Order::whereMonth('created_at', Carbon::now()->month)->count(),
            'sales' => [$sales,min($sales),max($sales)]
        ];
    }
}
