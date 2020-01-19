<?php

namespace App\Http\Middleware\InnerWebsite;

use Closure;

class IsBank
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
        $this->check_user_role_is_bank_user();

        return $next($request);
    }

    private function check_user_role_is_bank_user()
    {
        if( auth()->user()->role_id != 2 ) {
            abort(403);
        }
    }
}
