<?php

namespace App\Http\Controllers;

use App\Radusergroup;
use App\Voucher;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function receiveVoucher(Request $request)
    {
        $voucher = Voucher::active()->where('code', $request->voucher)->first();

        if ($voucher->is_active) {
            $plan = $voucher->plan()->first();
            Radusergroup::create([
                'username' => $request->mac,
                'groupname' => $plan->code,
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'Invalid voucher',
            ]);
        }
    }
}
