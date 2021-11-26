<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest:user')->except('logout');
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

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'purok'=> 'required',
            'brgy'=> 'required',
            'city'=> 'required',
            'landmark'=> 'required',
            'additional_address'=> 'required'
        ]);

        if(User::where('email',$request->email)->exists()){
            return ["error_email" => true];
        }
        
        $image_req = str_contains($request->image,'base64');

        if($image_req){
            $fileName = $this->uploadImage($request->image);
        }

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $image_req ? $fileName : null ,
            'phone_number' => $request->phone_number,
            'purok'=> $request->purok,
            'brgy'=> $request->brgy,
            'landmark'=> $request->landmark,
            'city'=> $request->city,
            'additional_address'=> $request->additional_address
        ]);
    }

    public function update(Request $request)
    {

        $user = $request->user();
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'purok'=> 'required',
            'brgy'=> 'required',
            'city'=> 'required',
            'landmark'=> 'required',
            'additional_address'=> 'required'
        ]);

        if(User::where('email',$request->email)->exists() && $user->email != $request->email ){
            return ["error_email" => true];
        }

        if($request->password || $request->confirm_password){
            if($request->password == $request->confirm_password){
                $user->password = $request->password ? bcrypt($request->password) : $user->password ;
            }
            else {
                return ["error" => "password not match"];
            }
        }

        if(str_contains($request->image,'base64')){
            if($user->image){
                Storage::delete('app/public/updloads/'.$user->image);
            }

            $user->image =  $this->uploadImage($request->image);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->purok = $request->purok;
        $user->brgy = $request->brgy;
        $user->city = $request->city;
        $user->landmark = $request->landmark;
        $user->additional_address = $request->additional_address;

        $user->save();

        return "success";
    }
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);
            
            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('user')->logout();

        $request->user()->token()->revoke();

        return "success";
    }


    public function details(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
