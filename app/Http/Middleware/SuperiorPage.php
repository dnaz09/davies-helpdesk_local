<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperiorPage
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
        $user = Auth::user();
        if($user->superior === 0){
            return $next($request);
        }
        else{            
            return redirect('restricted_page');
        }    
    }
}
