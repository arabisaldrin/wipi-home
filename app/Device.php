<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'type',
        'mac_address',
        'user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
