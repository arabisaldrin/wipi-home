<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
