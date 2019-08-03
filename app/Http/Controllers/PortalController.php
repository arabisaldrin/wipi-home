<?php

namespace App\Http\Controllers;

use App\Device;
use App\Radcheck;
use App\Radusergroup;
use App\User;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PortalController extends Controller
{

    /**
     * User submitted a voucher
     * Check validity and plan of the voucher
     */
    public function receiveVoucher(Request $request)
    {
        $voucher = Voucher::active()->where('code', $request->voucher)->first();

        if ($voucher) {
            if ($voucher->used_at) {
                // get generated password
                $radcheck = Radcheck::where('username', $request->mac)
                    ->where('attribute', 'Cleartext-Password')
                    ->first();

            } else {
                // if not used create voucher connection details

                // get voucher plan
                $plan = $voucher->plan()->first();

                $radcheck = Radcheck::create([
                    'username' => $request->mac,
                    'attribute' => 'Cleartext-Password',
                    'op' => ':=',
                    'value' => Str::random(20),
                ]);
                // Add this voucher to radusergroup
                Radusergroup::create([
                    'username' => $request->mac,
                    'groupname' => $plan->code,
                ]);
                // update voucher used_at timestamp
                $voucher->used_at = Carbon::now();
                $voucher->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'Valid',
                'login' => [
                    'password' => $radcheck->value,
                ],
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid voucher',
            ]);
        }
    }

    /**
     * Check if user has device associated
     * and requesting from one of this device
     */
    public function checkDeviceAccess(Request $request)
    {
        $user = User::with('devices')->where('username', $request->username)->first();

        if ($user && $user->devices->count()) {
            $device = $user->devices()->where('mac_address', $request->mac_address);
            if (!$device->exists()) {
                return response()->json(['allow' => false]);
            }
        }
        return response()->json(['allow' => true]);
    }

    /**
     * Get auto connect value of a user device using mac_address
     */
    public function checkAutoConnectDevice(Request $request)
    {
        $device = Device::with('owner')
            ->where('mac_address', $request->mac_address)
            ->first();

        if ($device && $device->owner) {
            $user = $device->owner;

            if ($user->auto_connect) {
                $password = Radcheck::where('username', $user->username)
                    ->where('attribute', 'Cleartext-Password')
                    ->first();
                return response()->json([
                    'connect' => true,
                    'login' => [
                        "username" => $user->username,
                        'password' => $password->value,
                    ],
                ]);
            }
        }
        return response()->json([
            'connect' => false,
        ]);
    }
}
