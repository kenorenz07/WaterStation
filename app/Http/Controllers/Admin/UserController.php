<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $per_page = $request->query('per_page') ? $request->query('per_page') : 10;

        return User::paginate($per_page);
    }

    public function uploadImage($image)
    {
        $exploded_base64 = explode(',', $image);
        $decoded_base64  = base64_decode($exploded_base64[1]);
        $extention = $this->string_between_two_string($exploded_base64[0], '/', ';');
        
        $fileName = 'cus_'.time().'.'.$extention;
        $path = storage_path('app/public/').$fileName;
    
        file_put_contents($path,$decoded_base64);   
        
        return $fileName;
    }

    public function string_between_two_string($str, $starting_word, $ending_word)
    {
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
        return '';
    }

    public function show (User $user) 
    {
        return $user;
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'purok'=> 'required',
            'brgy'=> 'required',
            'additional_address'=> 'required'
        ]);

        $image_req = str_contains($request->image,'base64');

        if($image_req){
            $fileName = $this->uploadImage($request->image);
        }

        $created = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'image' => $image_req ? $fileName : null ,
            'purok'=> $request->purok,
            'brgy'=> $request->brgy,
            'additional_address'=> $request->additional_address
        ]);

        return $created;
    }


    public function update(User $user,Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'purok'=> 'required',
            'brgy'=> 'required',
            'additional_address'=> 'required'
        ]);

        if(str_contains($request->image,'base64')){
            if($user->image){
                Storage::delete('app/public/updloads/'.$user->image);
            }

            $user->image =  $this->uploadImage($request->image);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = $request->password ? bcrypt($request->password) : $user->password ;
        $user->purok = $request->purok;
        $user->brgy = $request->brgy;
        $user->additional_address = $request->additional_address;

        $user->save();

        return "success";
    }

    public function delete(User $user)
    {
        if($user->image){
            Storage::delete('app/public/updloads/'.$user->image);
        }
        if($user->orders()->count() > 0 && $user->sales()->count() > 0 && $user->reviews()->count() > 0 && $user->carts()->count() > 0){
            return ["error" =>"User is connected to orders,sales,reviews or carts. Cannot be deleted"];
        }

        $user->delete();
    }


}
