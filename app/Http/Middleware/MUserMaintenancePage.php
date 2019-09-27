<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\AccessControl;

class MUserMaintenancePage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $access_control;

    public function __construct(AccessControl $access_control){

        $this->access_control = $access_control;
    }

    public function handle($request, Closure $next)
    {
        $id = Auth::id();
        $module_id = 18;

        $access_control = $this->access_control->CheckUserModule($id, $module_id);

        if($access_control){

            return $next($request);
        }
        else{

            return redirect('restricted_page');
        }
    }
}
