<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherGroup extends Model
{
    protected $fillable = [
        'description',
        'total_vouchers',
        'plan_id',
    ];
    protected $with = ['plan'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
