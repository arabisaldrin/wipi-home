<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Radusergroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = User::with('devices');
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
        $user = new User();
        $this->apply($user, $request);

        return $user;
    }

    public function apply(User $user, Request $request)
    {
        $oldUsername = $user->username;

        $user->fill($request->all());
        $user->plan_id = $request->plan['id'];
        $user->save();

        $user->devices()->delete();
        $user->devices()->createMany(array_filter($request->devices, function ($item) {
            return !empty($item['mac_address']);
        }));

        // add user to group/plan
        Radusergroup::updateOrCreate([
            'username' => $oldUsername,
        ], [
            'username' => $user->username,
            'groupname' => $request->plan['code'],
        ]);

        //Apply any additional attributes
        foreach ([$request->check, $request->reply] as $index => $arr) {
            foreach ($arr as $attr => $val) {
                $type = ['App\\Radcheck', 'App\\Radreply'][$index];
                if (empty($val)) {
                    $type::where([
                        'username' => $oldUsername,
                        'attribute' => $attr,
                    ])->delete();
                    continue;
                }
                $type::updateOrCreate([
                    'username' => $oldUsername,
                    'attribute' => $attr,
                ], [
                    'username' => $user->username,
                    'op' => ':=',
                    'value' => $val,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $check = ['none' => ''];
        $reply = ['none' => ''];
        DB::table('radcheck')
            ->where('username', $user->username)
            ->get()->each(function ($item) use (&$check) {
            $check[$item->attribute] = $item->value;
        });

        DB::table('radreply')
            ->where('username', $user->username)
            ->get()->each(function ($item) use (&$reply) {
            $reply[$item->attribute] = $item->value;
        });

        $user->check = $check;
        $user->reply = $reply;
        $user->load('plan', 'devices');

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $this->apply($user, $request);

        return $user;
    }

    /**
     * Activate/Deactivate user
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
    }

    /**
     * Destroy user and all related object
     */
    public function destroy(User $user)
    {
        $user->check()->delete();
        $user->reply()->delete();
        $user->group()->delete();
        $user->devices()->delete();
        $user->delete();
    }
}
