<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class HRPage
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
        

        if($user->dept_id === 6){

            return $next($request);
        }
        else{            

            return redirect('restricted_page');
        }    
    }
}
