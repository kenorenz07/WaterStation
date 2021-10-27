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
        $per_page = $request->query('per_page') ? $request->query('per_page') : 10;

        return $index::where('parents')paginate($per_page);
    }
}
