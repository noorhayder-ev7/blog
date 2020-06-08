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


    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = config('app.firebase_server_key');
    }

    public function addcomment(Request $request)
    {
        $cmt = new Comments();
        $id = $cmt->user_id = $request->input('user_id');
        $temp = User::find($id);
        if ($temp) {
            $cmt->post_id = $request->input('post_id');
            $cmt->content = $request->input('content');
            $cmd2 = $cmt->content = $request->input('content');
            $mydate = Carbon::now();
            $mydate->toDateTimeString();
            $cmt->created_at = $mydate;
            $cmt->save();
            $userIdC = Post::where('id', $cmt->post_id)->first();
            $userIdC = $userIdC->user_id;
            $userIdP = User::where('id', $userIdC)->first();
            $userIdP = $userIdP->token;
            if ($userIdC != $id) {
                $l = strlen($cmd2);
                if ($l > 25)
                    $rest = substr($cmd2, 0, 25);
                else
                    $rest = $cmd2;
                if ($cmt) {
                    $u = User::where('id', $id)->first(['name', 'token']);

                    $data = [
                        "to" => $userIdP,
                        "notification" =>
                            [

                                "title" => ' علق ' . $u->name . ' على مدونتك ',


                                "body" => $rest,
                            ],
                        "data" => [
                            "id" => $cmt->post_id,
                        ]
                        ,

                    ];
                    $dataString = json_encode($data);
                    $headers = [

                        'Authorization: key=' . $this->serverKey,
                        'Content-Type: application/json',
                    ];

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                    curl_exec($ch);

                    return response()->json($cmt);
                }
                else
                    return response()->json(['message' => 'NOT FOUND']);

                }
            elseif ($cmt)
                return response()->json($cmt);
            else
                return response()->json(['message' => 'NOT FOUND']);


        }
        else
            return response()->json(['message' => ' user not found']);
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




