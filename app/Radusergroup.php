<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radusergroup extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $table = 'radusergroup';
    protected $fillable = [
        'username',
        'groupname',
    ];
}
