<?php

namespace App\Http\Middleware\InnerWebsite;

use Closure;

class IsBillPaymentProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->check_user_role_is_bill_payment_provider_user();
        
        return $next($request);
    }

    private function check_user_role_is_bill_payment_provider_user()
    {
        if( auth()->user()->role_id != 6 ){
            abort(403);
        }
    } 
}
