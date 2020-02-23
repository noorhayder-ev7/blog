<?php

namespace App\Http\Controllers\Controllers;

use App\models\Comments;
use App\models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function getcomment(Request $request)
    {
        $cmt = new \App\models\Comments;
        $cmt->user_id=$request->input('user_id');
        $cmt->post_id=$request->input('post_id');
        $cmt->content = $request->input('content');
        $mydate = Carbon::now();
        $mydate->toDateTimeString();
        $cmt->created_at = $mydate;
        $cmt->save();
        if ($cmt)
        {
            return response()->json($cmt);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);

    }
    public function deletecomment(Request $request){

        $body = $request->all();
        $id= $body['id'];
        $data = (new \App\models\Comments)->where('id', $id)->delete();
        if ($data)
        {
            return response()->json(['message'=> 'DONE']);

        }
        else
            return response()->json(['message'=> 'NOT FOUND']);


    }
    public function commentpagination(Request $request)
    {   $body = $request->all();
        $id= $body['post_id'];

        $data=(new \App\models\Comments)->where('post_id', $id)->with(['user'])->paginate(10);

        return response()->json($data);
    }
}
