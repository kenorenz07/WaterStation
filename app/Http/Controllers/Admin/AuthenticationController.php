<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if(auth()->guard('admin')->attempt(['username' => request('username'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'admin']);
            
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Username and Password are Wrong.']], 200);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function update(Request $request)
    {
        $request->user()->update([
            "username" => $request->username,
            "password" => $request->password ? bcrypt($request->password) : $request->user()->password
        ]);
    }

    public function details(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
