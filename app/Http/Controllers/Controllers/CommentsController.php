<?php

namespace App\Http\Controllers\Controllers;

use App\models\Comments;
use App\models\Post;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function addcomment(Request $request)
    {
        $cmt = new Comments();
       $id= $cmt->user_id=$request->input('user_id');
        $temp=User::find($id);
        if($temp){
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
        else
            return response()->json(['message'=> ' user not found']);

    }
    public function deletecomment(Request $request){

        $body = $request->all();
        $id= $body['id'];
        $data = Comments::where('id', $id)->delete();
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

        $data=Comments::where('post_id', $id)->with(['user'])->latest()->paginate(6);

        return response()->json($data);
    }
}
