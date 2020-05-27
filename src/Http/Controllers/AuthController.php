<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Chelsymooy\Subscriptions\Http\Requests\LoginRequest;

/**
 * @group Authentication
 *
 */
class AuthController extends Controller {
    /**
     * Get
     *
     */
    public function get() {
        return view('subs::auth.login');
    }

    /**
     * Post
     *
     */
    public function post(LoginRequest $request)  {
        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        if (Auth::guard('web')->attempt($request->only('username', 'password'))) {
            return redirect()->intended(route('subs.dashboard.index'));
        }
        return redirect()->back()->withErrors(['Invalid credentials']);
    }

    /**
     * Logout
     *
     */
    public function logout() {
        Auth::guard('web')->logout();
        return redirect()->route('subs.login.get');
    }
}
