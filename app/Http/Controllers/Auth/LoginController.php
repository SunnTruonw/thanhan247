<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
          $this->middleware('guest')->except('logout');
        //  $this->middleware('guest:admin')->except('logout');
    }


    public function login(Request $request)
    {
        // validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        // attempt to log the user in
        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ], $request->remember)) {
            if (session()->has('urlBack')) {
                $url = session()->get('urlBack');
                session()->forget('urlBack');
                return redirect($url);
            }
            return redirect()->intended('/');
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('username', 'remember'));
    }

    // public function showAdminLoginForm()
    // {
    //     return view('auth.login', ['url' => 'admin']);
    // }

    // public function adminLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'   => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);

    //     if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    //         return redirect()->intended('/admin');
    //     }
    //     return back()->withInput($request->only('email', 'remember'));
    // }
}
