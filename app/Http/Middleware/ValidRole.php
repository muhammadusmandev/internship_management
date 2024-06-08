<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Traits\ApiResponse;

class ValidRole
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::user()->hasRole($role)) {
            if($request->wantsJson() || in_array('api', $request->route()->getAction('middleware'))){
                return $this->errorResponse(
                    [
                        'error' => 'Unauthorized to perform this action.'
                    ]
                    'Something went wrong!',
                    401
                );
            } else{
                return abort(401);
            }
        }

        return $next($request);
    }
}
