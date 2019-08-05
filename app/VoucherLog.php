<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherLog extends Model
{
    protected $fillable = [
        'voucher_code',
        'mac_address',
        'ssid',
        'nasid',
    ];

    protected $with = ['voucher'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_code', 'code');
    }
}
