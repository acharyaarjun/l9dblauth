<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminController extends Controller
{
    use AuthenticatesUsers;
    // *
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string|null

    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $user = Admin::where('email', $request->email)->first();
            Auth::guard('admin')->login($user);
            return redirect()->route('admin.home');
        }
        return redirect()->route('admin.login')->with('status', 'Failed To Process Login');
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('admin.home');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('status', 'Logout Successfully!');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
}
