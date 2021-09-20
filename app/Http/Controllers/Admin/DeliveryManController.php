<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeliveryManController extends Controller
{
    public function index() 
    {
        return DeliveryMan::with('orders')->get();
    }

    public function uploadImage($image)
    {
        $exploded_base64 = explode(',', $image);
        $decoded_base64  = base64_decode($exploded_base64[1]);
        $extention = $this->string_between_two_string($exploded_base64[0], '/', ';');
        
        $fileName = time().'.'.$extention;
        $path = storage_path('app/public/').$fileName;
    
        file_put_contents($path,$decoded_base64);   
        
        return $fileName;
    }

    public function string_between_two_string($str, $starting_word, $ending_word){
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
        return '';
    }
      
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
        ]);

        $image_req = str_contains($request->image,'base64');

        if($image_req){
            $fileName = $this->uploadImage($request->image);
        }

        $created = DeliveryMan::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'image' => $image_req ? $fileName : null ,
            'phone_number' => $request->phone_number
        ]);

        return $created;

    }

    public function show(DeliveryMan $delivery_man)
    {
        return [
            "delivery_man" => $delivery_man,
            "orders" => $delivery_man->orders,
        ];
    }


    public function update(DeliveryMan $delivery_man,Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'phone_number' => 'required',
        ]);

        if(str_contains($request->image,'base64')){
            if($delivery_man->image){
                Storage::delete('app/public/updloads/'.$delivery_man->image);
            }

            $delivery_man->image =  $this->uploadImage($request->image);
        }

        $delivery_man->name = $request->name;
        $delivery_man->username = $request->username;
        $delivery_man->phone_number = $request->phone_number;
    
        $delivery_man->save();

        return 'inmamo';

    }

    public function delete(DeliveryMan $delivery_man)
    {
        if($delivery_man->image){
            Storage::delete('app/public/updloads/'.$delivery_man->image);
        }

        $delivery_man->orders()->update([
            'delivery_man_id' => null
        ]);

        $delivery_man->delete();
    }
}
