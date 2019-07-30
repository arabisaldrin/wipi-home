<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radreply extends Model
{
    public $timestamps = false;
    protected $table = 'radreply';
    protected $fillable = [
        'username',
        'attribute',
        'value',
        'op',
    ];
}
