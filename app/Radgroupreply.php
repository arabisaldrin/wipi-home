<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radgroupreply extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    public $timestamps = false;

    protected $table = 'radgroupreply';
    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value',
    ];
}
