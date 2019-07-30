<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'description',
        'expiration',
        'expires_at',
        'plan_id',
    ];

    protected $dates = [
        'expires_at',
        'used_at',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    protected static function boot()
    {
        parent::boot();

    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('is_active', 1);
        $builder->orWhere(function ($q) {
            $q->whereNotNull('expires_at');
            $q->where('expires_at', '<=', Carbon::now());
        });

    }
}
