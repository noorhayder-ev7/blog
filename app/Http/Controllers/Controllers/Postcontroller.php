<?php

namespace App\Http\Controllers\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Postcontroller extends Controller
{
    public function index(Request $request)
    {

        $data= (new \App\models\Post)->paginate(10);
        return response()->json($data);
    }
}
