<?php

namespace App\Http\Controllers;

use App\Plan;
use App\VoucherGroup;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Plan::withCount(['users' => function ($q) {
            return $q->where('is_active', 1);
        }]);
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
        $plan = new Plan();

        $this->apply($plan, $request);

        return $plan;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        $details = collect($plan->check()->get())->merge($plan->reply()->get());

        $plan = $plan->toArray();

        $plan['check'] = new \stdClass();
        $plan['reply'] = new \stdClass();

        foreach (['check', 'reply'] as $type) {
            foreach ($details as $detail) {
                $attribute = $detail->attribute;
                $plan[$type]->$attribute = $detail->value;
            }
        }

        return $plan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $this->apply($plan, $request);

        return $plan;
    }

    public function apply(Plan $plan, Request $request)
    {
        $oldCode = $plan->code;

        $plan->fill($request->all());
        $plan->save();

        foreach ([$request->check, $request->reply] as $index => $arr) {
            foreach ($arr as $attr => $val) {
                $type = ['App\\Radgroupcheck', 'App\\Radgroupreply'][$index];
                if (empty($val)) {
                    $type::where([
                        'groupname' => $oldCode,
                        'attribute' => $attr,
                    ])->delete();
                    continue;
                }
                $type::updateOrCreate([
                    'groupname' => $oldCode,
                    'attribute' => $attr,
                ], [
                    'groupname' => $plan->code,
                    'op' => ':=',
                    'value' => $val,
                ]);
            }
        }
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        $plan->reply()->delete();
        $plan->check()->delete();
        VoucherGroup::where('plan_id', $plan->id)->delete();
    }
}
