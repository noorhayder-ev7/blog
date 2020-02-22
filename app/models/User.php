<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    public function post()
    {
        return $this->hasMany('App\models\Post');

    }
}
