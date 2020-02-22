<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    public function post()
    {
        return $this->hasMany('App\models\Post');

    }
}
