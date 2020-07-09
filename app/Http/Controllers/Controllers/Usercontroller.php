<?php

namespace App\Http\Controllers\Controllers;

use App\blocked_user;
use App\BlockedUser;
use App\models\Comments;
use App\models\Post;
use App\models\Rates;
use App\models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $users->password = md5($request->input('password'));
        $body=User::where('email',$users->email)->first();
        if($body)
            return response()->json(['message'=> 'email exists']);
        else {
            $users->save();
            if ($users) {
                $users->id = $random_id;
                return response()->json($users);
            } else
                return response()->json(['message' => 'ERROR']);
        }
    }
    public function registerbyfacebook(Request $request)
    {
        $body = $request->all();
        $id = $body['id'];
        $userFromFacebook = User::find($id);
        if ($userFromFacebook)
        {
            return response()->json(['message'=> 'already...']);

        }
        else {
            $data=new User;
            $temp=$data->id = $request->input('id');
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->picture = $request->input('picture');
            $body=User::where('email',$data->email)->first();
            if($body)
            {   $Id=$body['id'];
                $body=User::where('email',$data->email)->
                update(['id'=>$temp]);
                $body=User::where('email',$data->email)->
                update(['name'=>$data->name]);
                $body=User::where('email',$data->email)->
                update(['picture'=>$data->picture]);
                $body1=Post::where('user_id',$Id)->update(['user_id'=>$temp]);
                $body2=Comments::where('user_id',$Id)->update(['user_id'=>$temp]);
                $body3=Rates::where('user_id',$Id)->update(['user_id'=>$temp]);
                $body=User::where('email',$data->email)->first();
                return response()->json($body);}
            else
            {
                $data->save();
                $data->id =$temp;
                return response()->json($data);}

        }
    }
    public function login(Request $request)
    {
        $body = $request->all();
        $password = $body['password'];
        $username=$body['email'];
        if ($request->input('db'))
        {
            $userFromDB1 = User::where('email', $username)->where('password', md5($password))->first();
            $userFromDB2 = Student::where('email', $username)->first();

            if ($userFromDB1) {
                $data = User::where('email', $username)->where('password', md5($password))->first();

                return response()->json($data);

            }

            elseif ($userFromDB2)
            { $userFromFace = User::where('email', $username)->whereNotNull('password')->first();
                $userFromDB1 =  User::where('email', $username)->first();
                if($userFromFace==null&&$userFromDB1)
                {   $userFromDB1=User::where('email', $username)->first();
                    $userFromDB2= Student::where('email', $username)->where('password', md5($password))->first(['password']);
                    $userFromDB1->password=$userFromDB2['password'];
                    $userFromDB1->save();
                    $data = User::where('email', $username)->where('password', md5($password))->first();
                    return response()->json($data);
                }

                else
                { $userFromDB2 = Student::where('email', $username)->where('password', md5($password))->first();
                    if($userFromDB2)
                    { $userFromDB2 = Student::where('email', $username)->where('password', md5($password))->first(['name', 'email', 'password']);
                        $users = new User();
                        $random_id = rand(1000000, 9999999);
                        $users->id = $random_id;
                        $users->name = $userFromDB2['name'];
                        $users->email = $userFromDB2['email'];
                        $users->password = $userFromDB2['password'];
                        $users->save();
                        $users->id = $random_id;
                        $data = User::where('email', $username)->where('password', md5($password))->first();
                        return response()->json($data);}
                    else
                        return response()->json(['message'=> 'NOT FOUND']);

                }

            }
            else  return response()->json(['message'=> 'NOT FOUND']);

        }
        else{
            $data = User::where('email',$username)->where('password', md5($password ))->first();
            if ($data)
            {
                return response()->json($data);

            }
            else
                return response()->json(['message'=> 'NOT FOUND']);}


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
        $search_user = User::Where('name', 'like', "%{$data}%")
            ->orWhere('email', 'like', "%{$data}%")
            ->orWhere('phone', 'like', "%{$data}%")
            ->get();
        return response()->json([ 'data' => $search_user ]);

    }
    public function updateprofile(Request $request)
    {

        $body = $request->all();
        $id= $body['id'];

        $data = User::where('id', $id)->update(['name' => $body['name']]);
        if ($request->hasFile('image'))//read and store img.
        {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $location ='../aqlam/aqlam/image';
            $image->move($location, $name);
            $temp= 'https://alkafeelblog.edu.turathalanbiaa.com/aqlam/image/';
            $data = User::where('id', $id)->update(['picture' => $temp.$name]);
            return response()->json(['message' => 'update DONE']);


        }
        if ($data)
            return response()->json(['message' => 'update DONE']);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }
    public function saveToken(Request $request)
    {

        $body = $request->all();
        $id= $body['id'];

        $data = User::where('id', $id)->update(['token' => $body['token']]);

        if ($data)
            return response()->json(['message' => 'update DONE']);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }
    public function block_user(Request $request)
    {

        $body = $request->all();
        $my_id= $body['my_id'];
        $blocked_user_id= $body['blocked_user_id'];

        $blocked_user = new BlockedUser();
        $blocked_user->user_id = $my_id;
        $blocked_user->blocked_user_id = $blocked_user_id;


        if ($blocked_user->save())
            return response()->json(['message' => 'Blocked']);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }
    public function unblock_user(Request $request)
    {

        $body = $request->all();
        $my_id= $body['my_id'];
        $blocked_user_id= $body['blocked_user_id'];

        $deletedRows = BlockedUser::where('user_id', $my_id)->where('blocked_user_id', $blocked_user_id)->delete();
        if ($deletedRows)
            return response()->json(['message' => 'unblocked']);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }

    public function all_block_user(Request $request)
    {

        $body = $request->all();
        $my_id= $body['my_id'];
        $SQL = "SELECT users.name , users.id as user_id  
                FROM users LEFT JOIN blocked_user ON blocked_user.blocked_user_id = users.id 
                WHERE blocked_user.user_id = ?";


        $data = DB::select($SQL, [$my_id]);
        if ($data)
            return response()->json($data);

        else
            return response()->json(['message' => 'NOT FOUND']);
    }

}
