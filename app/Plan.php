<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $fillable = ['code', 'description'];

    public function check()
    {
        return $this->hasMany(Radgroupcheck::class, 'groupname', 'code');
    }

    public function reply()
    {
        return $this->hasMany(Radgroupreply::class, 'groupname', 'code');
    }

}
