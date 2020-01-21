<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//use Illuminate\Foundation\Auth\ThrottlesLogins;

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
    protected $redirectTo = 'http://yoippsp.com';
    protected $maxAttempts = 3;
    protected $decayMinutes = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        
        //checking for honey pot /spam bot
        if( request()->new_email ){
            /**
             * ######### ADD the ip to Ip bannlist table
             */
            return back()
                ->withInput()
                ->withErrors([
                    'email_mobile' => 'These credentials do not match our records.',
                ]);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email_mobile'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('email_mobile'), FILTER_VALIDATE_EMAIL ) 
            ? 'email' 
            : 'mobile_number';

        $request->merge([
            $login_type => $request->input('email_mobile')
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
                //dd('to many');
            return $this->sendLockoutResponse($request);
        }

        if ( \Auth::attempt( $request->only($login_type, 'password'), $request->filled('remember') ) ) {
            $this->approval_check();
            return redirect()->intended($this->redirectPath());
        }
        $this->incrementLoginAttempts($request);

        return back()
            ->withInput()
            ->withErrors([
                'email_mobile' => 'These credentials do not match our records.',
            ]);
    } 

    protected function redirectTo()
    {
        $role_id = auth()->user()->role_id;
        
        switch($role_id){
            case 1:
                return 'http://admin.yoippsp.com';
            case 2:
                return 'http://account.yoippsp.com/bank/dashboard';
            case 3:
                return 'http://account.yoippsp.com/ba/dashboard';
            case 4:
                return 'http://account.yoippsp.com/wa/dashboard';
            case 5:
                return 'http://account.yoippsp.com/pa/dashboard';
            case 6:
                return 'http://account.yoippsp.com/bpa/dashboard';
            case 7:
                return 'http://account.yoippsp.com/spa/dashboard';
            case 8:
                return 'http://admin.yoippsp.com';
            default:
                return 'http://yoippsp.com';
        }

    }


    /**
     * The user has been appoved
     */
    private function approval_check()
    {
        $approval_need_roles = [2,6,7];
        $user = auth()->user();
        if( in_array( $user->role_id, $approval_need_roles) && $user->approved != 'Approved' ) {
            auth()->guard()->logout();
            abort(503);
        }
    }


}
