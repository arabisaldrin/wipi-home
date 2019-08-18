<?php

namespace App\Http\Controllers;

use App\Voucher;
use App\VoucherGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VoucherGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $builder = VoucherGroup::query();

        return Pagination::paginate($builder, request());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $voucherGroup = new VoucherGroup($request->all());
        $voucherGroup->save();

        return $voucherGroup;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VoucherGroup  $voucherGroup
     * @return \Illuminate\Http\Response
     */
    public function show(VoucherGroup $voucherGroup)
    {
        return $voucherGroup;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VoucherGroup  $voucherGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoucherGroup $voucherGroup)
    {
        $voucherGroup->fill($request->all());
        $voucherGroup->save();

        return $voucherGroup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VoucherGroup  $voucherGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoucherGroup $voucherGroup)
    {
        $voucherGroup->vouchers()->delete();
        $voucherGroup->delete();
    }

    public function archive(VoucherGroup $voucherGroup)
    {
        $archive = request()->archive;
        if ($archive) {
            $voucherGroup->archived_at = Carbon::now();
        } else {
            $voucherGroup->archived_at = null;
        }
        $voucherGroup->save();

        Voucher::where('group_id', $voucherGroup->id)->update([
            'is_active' => $archive,
        ]);

        return $voucherGroup;
    }
}
