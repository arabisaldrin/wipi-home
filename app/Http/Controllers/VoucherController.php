<?php

namespace App\Http\Controllers;

use App\Events\VoucherGroupAdded;
use App\Voucher;
use App\VoucherGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Voucher::query();
        $filters = json_decode($request->filters);
        if ($filters && $filters->group_id) {
            $builder->where('group_id', $filters->group_id);
        }
        $builder->orderBy('created_at', 'DESC');

        return Pagination::paginate($builder, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new VoucherGroup($request->all());
        $group->save();

        $vouchers = [];
        for ($i = 0; $i < $request->total_vouchers; $i++) {
            $voucher = [
                'group_id' => $group->id,
                'plan_id' => $request->plan_id,
                'code' => $this->generateVoucherCode(),
                'expires_at' => $request->expiration,
                'created_at' => Carbon::now(),
            ];
            array_push($vouchers, $voucher);
        }

        Voucher::insert($vouchers);

        broadcast(new VoucherGroupAdded($request->user()))->toOthers();

        return $vouchers;
    }

    public function generateVoucherCode()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        return $voucher;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $voucher->fill($request->all());
        $voucher->save();

        return $voucher;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->is_active = 0;
        $voucher->save();
    }
}
