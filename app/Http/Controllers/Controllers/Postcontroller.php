<?php

namespace App\Http\Controllers\controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\models\Post;
class Postcontroller extends Controller
{
    public function index(Request $request)
    {
        $data= (new \App\models\Post)->paginate(10);
        return response()->json($data);
    }
    public function getposts(Request $request)
    {
        $post = new \App\models\Post;
        $post->user_id=$request->input('user_id');
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $mydate = Carbon::now();
        $mydate->toDateTimeString();
        $post->created_at = $mydate;
        $post->rate="0";
        $post->views="0";
        $post->tags="NULL";
        $post->status="0";
        $post->category_id=$request->input('category_id');
        $post->save();
        if ($post)
        {
            return response()->json($post);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);

    }
    public function deletepost(Request $request){

        $body = $request->all();
        $id= $body['id'];
        $data = (new \App\models\Post)->where('id', $id)->delete();
        if ($data)
        {
            return response()->json(['message'=> 'DONE']);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }
    public function updateviews(Request $request){

        $body = $request->all();
        $id= $body['id'];
        $data = (new \App\models\Post)->where('id', $id) ->increment('views', 1);
        if ($data)
        {
            return response()->json(['message'=> 'update DONE']);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }

}

