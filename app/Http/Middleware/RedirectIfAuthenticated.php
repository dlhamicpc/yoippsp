<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect($this->redirectTo());
        }

        return $next($request);
    }


    private function redirectTo()
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
            default:
                return 'http://yoippsp.com';
        }
    }

}
