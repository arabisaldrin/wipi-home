<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'plan_id',
        'username',
        'first_name',
        'last_name',
        'email_address',
        'mobile_number',
        'auto_connect',
    ];

    public function check()
    {
        return $this->hasMany(Radcheck::class, 'username', 'username');
    }

    public function reply()
    {
        return $this->hasMany(Radreply::class, 'username', 'username');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function group()
    {
        return $this->belongsTo(Radusergroup::class, 'username', 'username');
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
