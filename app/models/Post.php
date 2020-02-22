<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\models\User');
    }
    public function cat()
    {
        return $this->belongsTo('App\models\categories');
    }

}
