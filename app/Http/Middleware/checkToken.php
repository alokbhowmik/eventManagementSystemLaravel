<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;

class checkToken
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
        $token = $request->header('Token');
        $user_id = DB::table('tokens')->where('token',$token)->value('user_id');
        
        if(empty($user_id)){
            
            return response()->json('Unauthorized',401);
        }
        
        return $next($request);
    }
}
