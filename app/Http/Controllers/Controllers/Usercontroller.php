<?php

namespace App\Http\Controllers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\String_;
use App\models\User;
class Usercontroller extends Controller
{
    public function register(Request $request)
    {

            $users = new User();
            $random_id = rand(1000000,9999999);
            $users->id = $random_id;
            $users->name = $request->input('name');
            $users->email = $request->input('email');
            $users->password = $request->input('password');
           $users->save();

            if ($users)
            {
                $users->id = $random_id;
                return response()->json($users);
            }
            else
                return response()->json(['message' => 'ERROR']);

    }
    public function login(Request $request){

        $body = $request->all();
       $password = $body['password'];
        $username=$body['email'];
       $data = User::where('email',$username)->where('password', $password )->first();
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
        $data = User::where('id',$id)->first();
        if ($data)
        {
            return response()->json($data);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }
    public function userpagination(Request $request)
    {  $sortby=$request->input('sortby');
    if($sortby==0) {
        $data = User::paginate(10);
        return response()->json($data);
    }
    elseif ($sortby==1){
        $data = User::orderBy('points', 'desc')->paginate(10);
        return response()->json($data);
    }
    }
    public function getSearchResults(Request $request)
    { $data = $request->get('data');
        $search_user = User::where('id', 'like', "%{$data}%")
            ->orWhere('name', 'like', "%{$data}%")
            ->orWhere('email', 'like', "%{$data}%")
            ->orWhere('description', 'like', "%{$data}%")
            ->orWhere('picture', 'like', "%{$data}%")
            ->orWhere('facebook', 'like', "%{$data}%")
            ->orWhere('instagram', 'like', "%{$data}%")
            ->orWhere('twitter', 'like', "%{$data}%")
            ->orWhere('phone', 'like', "%{$data}%") ->get();

            return response()->json([ 'data' => $search_user ]);





    }
    public function updateprofile(Request $request)
    {

        $body = $request->all();
        $id= $body['id'];

        $data = User::where('id', $id)->update([
            'name' => $body['name'],
            'picture' => $body['picture'],
            'email'=>$body['email'],
            'password'=>$body['password']
        ]);
        if ($data)
            return response()->json(['message' => 'update DONE']);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }



}
