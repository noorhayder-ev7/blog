<?php

namespace App\Http\Controllers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Usercontroller extends Controller
{
    public function register(Request $request)
    {
        $users=new \App\models\User;
        $users->name=$request->input('name');
        $users->email=$request->input('email');
        $users->password=$request->input('password');
//        $users->phone=$request->input('phone');
        $users->save();
        return response()->json($users);
    }

    public function login(Request $request){

        $body = $request->all();
       $password = $body['password'];
        $username=$body['email'];
//        $data = (new \App\models\User)->where('email',$username)->where('password', $password )->first();
        $data = (new \App\models\User)->where('email',$username)->first();
        if ($data)
        {
            return response()->json($data);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }
}
