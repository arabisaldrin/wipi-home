<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoggedOut;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating operators for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override
     */
    protected function authenticated($request, $operator)
    {
        $operator->api_token = Str::random(60);
        $operator->save();

        return response($operator, 200);
    }

    /**
     * Override
     */
    protected function sendFailedLoginResponse($request)
    {
        return response('Login Faield', 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $this->guard()->logout();

        $request->session()->invalidate();

        // broadcast logout event
        broadcast(new LoggedOut($user))->toOthers();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut($request)
    {
        return redirect('/login');
    }
}
