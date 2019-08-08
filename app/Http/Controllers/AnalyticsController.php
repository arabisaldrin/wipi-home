<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public function voucherCount()
    {
        DB::statement("SET SQL_MODE=''");
        $result = DB::table('vouchers')
            ->selectRaw("count(id) as total,count(used_at) as used,code as last")
            ->orderBy('used_at', 'desc')
            ->first();
        return response()->json($result);
    }

    public function userCount()
    {
        $result = DB::table('users')
            ->selectRaw("count(*) as total,sum(is_active) as active")
            ->first();

        return response()->json($result);
    }

    public function dataUsage()
    {
        $result = DB::table('radacct')
            ->selectRaw("sum(acctoutputoctets) / 1000000000 as download,sum(acctinputoctets) / 1000000000 as upload")
            ->whereDate('acctstarttime', '>=', Carbon::now()->subDay(2))
            ->first();

        return response()->json($result);
    }

    public function monthlyTrends()
    {
        DB::statement("SET SQL_MODE=''");

        $start = (new Carbon('first day of this month'))->format('Y-m-d');
        $end = (new Carbon('last day of this month'))->format('Y-m-d');

        $query = DB::table('radacct')
            ->whereRaw("date(acctstarttime) between '$start' and '$end'")
            ->groupBy(DB::raw("date(acctstarttime)"))
            ->orderBy(DB::raw("acctstarttime"), 'asc');

        $dates = $query
            ->selectRaw("date(acctstarttime) as date")
            ->get()->pluck('date');

        $data = $query
            ->selectRaw("sum(acctoutputoctets + acctinputoctets) / 1000000000 as total_usage,count(*) as connection")
            ->get();

        return [
            'labels' => $dates,
            'usage' => $data->map(function ($e) {return $e->total_usage;}),
            'connection' => $data->map(function ($e) {return $e->connection;}),
        ];
    }

    public function annualTrends()
    {
        DB::statement("SET SQL_MODE=''");

        $start = date('Y-01-01');
        $end = date('Y') . '-12-31';

        $query = DB::table('radacct')
            ->whereRaw("date(acctstarttime) between '$start' and '$end'")
            ->groupBy(DB::raw("month(acctstarttime)"))
            ->orderBy(DB::raw("acctstarttime"), 'asc');

        $months = $query
            ->selectRaw("month(acctstarttime) as month")
            ->get()->pluck('month');

        $data = $query
            ->selectRaw("sum(acctoutputoctets + acctinputoctets) / 1000000000 as total_usage,count(*) as connection")
            ->get();

        return [
            'labels' => $months,
            'usage' => $data->map(function ($e) {return $e->total_usage;}),
            'connection' => $data->map(function ($e) {return $e->connection;}),
        ];
    }
}
