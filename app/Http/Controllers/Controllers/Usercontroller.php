<?php

namespace App\Http\Controllers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\String_;

class Usercontroller extends Controller
{
    public function register(Request $request)
    {
            $id=rand(1000000,9999999);
            $users = new \App\models\User;
            $users->id=$id;
            $users->name = $request->input('name');
            $users->email = $request->input('email');
            $users->password = $request->input('password');

            $users->save();
        if ($users)
        {
            return response()->json($users);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);



    }

    public function login(Request $request){

        $body = $request->all();
       $password = $body['password'];
        $username=$body['email'];
       $data = (new \App\models\User)->where('email',$username)->where('password', $password )->first();
        if ($data)
        {
            return response()->json($data);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }
    public function profile(Request $request){

        $body = $request->all();
        $id = $body['id'];
        $data = (new \App\models\User)->where('id',$id)->first();
        if ($data)
        {
            return response()->json($data);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }

}
