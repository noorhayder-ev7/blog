<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{  protected $connection = 'mysql2';
    protected $table = 'student';
    protected $hidden = ['password'];
    public $timestamps = false;
}
