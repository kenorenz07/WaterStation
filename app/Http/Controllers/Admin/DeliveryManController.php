<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;

class DeliveryManController extends Controller
{
    public function index() 
    {
        return DeliveryMan::with('orders')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
        ]);

        $created = DeliveryMan::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'image' => $request->image,
            'phone_number' => $request->phone_number
        ]);

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

        return $created;

    }

    public function show(DeliveryMan $delivery_man)
    {
        return $delivery_man->with('orders')->first();
    }


    public function update(DeliveryMan $delivery_man,Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
        ]);
    }
}
