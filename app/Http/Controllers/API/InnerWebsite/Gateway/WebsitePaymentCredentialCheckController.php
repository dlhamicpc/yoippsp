<?php

namespace App\Http\Controllers\API\InnerWebsite\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\InnerWebsite\Transaction\WebsitePaymentTransactionController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class WebsitePaymentCredentialCheckController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WebsitePaymentCredentialCheckController Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after payment.
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

        $payment_type = filter_var($request->input('email_mobile'), FILTER_VALIDATE_EMAIL ) 
            ? 'email' 
            : 'mobile_number';

        $request->merge([
            $payment_type => $request->input('email_mobile')
        ]);


        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ( \Auth::attempt( $request->only($payment_type, 'password') ) ) {
            return $this->perfrom_transaction();
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

    }

    private function perfrom_transaction()
    {
        
        $website_transaction = new WebsitePaymentTransactionController();
        $this->redirectTo = $website_transaction->set_data();
        $balance_sufficient = $website_transaction->check_balance();

        if( $balance_sufficient == false ) {
            return back()
                ->withInput()
                ->withErrors([
                    'email_mobile' => 'Insufficient Balance. Login to your yoippsp account and deposit to your yoippsp wallet.',
            ]);
        }
        else {
            $website_transaction_status = $website_transaction->perform_transaction();

            if( $website_transaction_status == true ) {
                auth()->guard()->logout();
                return redirect( $this->redirectTo );
            }
            else {
                return back()
                    ->withInput()
                    ->withErrors([
                        'email_mobile' => 'Something went wrong!! Please try again.',
                ]);
            }
        }
    }


}
