<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest:delivery_man')->except('logout');
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


    public function details(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
