<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radcheck extends Model
{
    public $timestamps = false;
    protected $table = 'radcheck';
    protected $fillable = [
        'username',
        'attribute',
        'value',
        'op',
    ];
}
