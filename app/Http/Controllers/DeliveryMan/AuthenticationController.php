<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest:delivery_man')->except('logout');
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
    
    public function login(Request $request)
    {
        $validator = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if(auth()->guard('delivery_man')->attempt(['username' => request('username'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'delivery_man']);
            
            $delivery_man = DeliveryMan::select('delivery_men.*')->find(auth()->guard('delivery_man')->user()->id);
            $success =  $delivery_man;
            $success['token'] =  $delivery_man->createToken('MyApp',['delivery_man'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Username and Password are Wrong.']], 200);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('delivery_man')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function update(Request $request)
    {
        $delivery_man = $request->user();
        
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'phone_number' => 'required',
        ]);

        if($request->password || $request->confirm_password){
            if($request->password == $request->confirm_password){
                $delivery_man->password = $request->password ? bcrypt($request->password) : $delivery_man->password ;
            }
            else {
                return ["error" => "password not match"];
            }
        }
        if(str_contains($request->image,'base64')){
            if($delivery_man->image){
                Storage::delete('app/public/updloads/'.$delivery_man->image);
            }

            $delivery_man->image =  $this->uploadImage($request->image);
        }

        $delivery_man->name = $request->name;
        $delivery_man->username = $request->username;
        $delivery_man->phone_number = $request->phone_number;

        return $delivery_man->save();
    }


    public function details(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
