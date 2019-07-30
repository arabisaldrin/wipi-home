<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radgroupcheck extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    public $timestamps = false;

    protected $table = 'radgroupcheck';
    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value',
    ];
}
