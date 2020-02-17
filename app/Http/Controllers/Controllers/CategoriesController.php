<?php

namespace App\Http\Controllers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function getcat(Request $request)
    {
        $data= (new \App\models\categories)->all();
        return response()->json($data);


    }
}
