<?php

namespace App\Http\Controllers;

use App\Vip;
use Illuminate\Http\Request;

class VipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Vip::with('devices');
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
        $vip = new Vip($request->all());
        $vip->save();

        $devices = array_filter($request->devices, function ($item) {
            return !empty($item['mac_address']);
        });

        $vip->devices()->createMany($devices);

        return $vip;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vip  $vip
     * @return \Illuminate\Http\Response
     */
    public function show(Vip $vip)
    {
        return $vip->load('devices');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vip  $vip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vip $vip)
    {
        $vip->fill($request->all());
        $vip->save();

        $vip->devices()->delete();
        $vip->devices()->saveMany($request->devices);

        return $vip;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vip  $vip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vip $vip)
    {
        $vip->delete();
        $vip->devices()->delete();
    }
}
