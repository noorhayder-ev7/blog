<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\models\User')->select(['id', 'name','picture']);

    }
    public function cat()
    {
        return $this->belongsTo('App\models\Category', 'category_id');
    }


}
