<?php

namespace App\Http\Controllers;

use App\Device;
use App\Radcheck;
use App\Radgroupcheck;
use App\Radusergroup;
use App\User;
use App\Voucher;
use App\VoucherLog;
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
            $username = $request->mac . "_$voucher->code";
            // get voucher plan
            $plan = $voucher->plan()->first();

            // if voucher already used
            if ($voucher->used_at) {
                // get logs for simultaneous checking
                $check = Radgroupcheck::where('groupname', $plan->code)
                    ->where('attribute', 'Simultaneous-Use')
                    ->first();

                // if [Simultaneous-Use] attribute exists check voucher count usage
                // group by mac_address to specify actual devices count
                if ($check) {
                    $logCount = VoucherLog::where('voucher_code', $voucher->code)
                        ->groupBy('mac_address')->count();
                    if ($logCount == $check->value) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Maximum device usage reach',
                        ]);

                    }
                }
                // passed [Simultaneous-Use] checking and can be used again
                // get previous generated password
                $radcheck = Radcheck::where('username', $username)
                    ->where('attribute', 'Cleartext-Password')
                    ->first();

            } else {
                // if not used create voucher connection details

                $radcheck = Radcheck::create([
                    'username' => $username,
                    'attribute' => 'Cleartext-Password',
                    'op' => ':=',
                    'value' => Str::random(20),
                ]);
                // Add this voucher to radusergroup
                Radusergroup::create([
                    'username' => $username,
                    'groupname' => $plan->code,
                ]);
                // update voucher used_at timestamp
                $voucher->used_at = Carbon::now();
                $voucher->save();

            }
            // log the voucher usage
            VoucherLog::create([
                'voucher_code' => $voucher->code,
                'mac_address' => $request->mac,
                'ssid' => $request->ssid,
                'nasid' => $request->nasid,
            ]);

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
