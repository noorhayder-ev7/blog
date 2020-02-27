<?php

namespace App\Http\Controllers\controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\models\Post;
class Postcontroller extends Controller
{
    public function postpagination(Request $request)
    {
        $body = $request->all();
        $id= $body['user_id'];
        $data= Post::with('user')->where('user_id', $id)->paginate(10);

        return response()->json($data);
    }
    public function index(Request $request)   //get posts depend on sort by
    {    $sortby=$request->input('sortby');
       if($sortby==0)// get all posts by default
       {
        $data = Post::with(['user','cat'])->paginate(10);
        return response()->json($data);
       }
       elseif ($sortby==1)//get posts depend on views
    {
        $data = Post::with(['user','cat'])->orderBy('views','desc')->paginate(10);
        return response()->json($data);

    }
       elseif ($sortby==2)//get posts depend on recent post
       {
           $data = Post::with(['user','cat'])->latest()->paginate(10);
           return response()->json($data);

       }
        return response()->json(['message'=> 'ERROR']);
    }
    public function addposts(Request $request)
    {
        $post = new Post();
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
        if ($request->hasFile('input_img'))//read and store img.
        {
            $image = $request->file('input_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $post->image = $name;
            $post->save();
            return back()->with('success','Image Upload successfully');

         }
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
        $data = Post::where('id', $id)->delete();
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
        $data = Post::where('id', $id) ->increment('views', 1);
        if ($data)
        {
            return response()->json(['message'=> 'update DONE']);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }

}

