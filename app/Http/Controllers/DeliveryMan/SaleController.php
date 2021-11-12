<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function getAll(Request $request)
    {
        return $request->user()->sales;
    }
}
