<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\models\User')->select(['id','name', 'email']);

    }
    public function comment()
    {
        return $this->belongsTo('App\models\Post');
    }
}
