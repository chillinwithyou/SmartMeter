<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    //
    public function login()
    {

        return view("users.login");

    }

    public function loginUser(Request $request)
    {

        $validated = $request->validate([
            "email" => ['required'],
            "password" => ['required'],
        ]);

        $meterAPI = new MeterAPI();


        if(Auth::attempt($validated)){

            $user = Auth::user();

            $apiKey = $meterAPI->generateKey($user->name, $validated["password"]);

            if($apiKey){
                Cache::put("username", $user->name, now()->addHours(23));
                Cache::put("apiKey", $apiKey, now()->addHours(23));
                return redirect(route("dashboard"));
            }
        }

        return back();
        

    }

}
