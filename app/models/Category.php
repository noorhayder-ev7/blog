<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    public function posts()     {
        return $this->hasMany('App\models\Post');

    }
}
