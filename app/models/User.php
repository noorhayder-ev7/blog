<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $hidden = ['password'];
    public $timestamps = false;
    public function post()
    {
        return $this->hasMany('App\models\Post');

    }
    public function cmd()
    {
        return $this->hasMany('App\models\Comments');

    }
}
