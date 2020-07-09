<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{

    protected $table = 'blocked_user';
    public $timestamps = false;
}
