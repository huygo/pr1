<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next,...$guards)
    {
        if (Auth::check()) {
            if (Auth::user()->status == 2){
                if ($request->route()->getName() == 'room' || $request->route()->getName() =='student'){
                    abort(403);
                }
                $student = true;
            }else{
                $student = false;
            }
            $request->session()->put('is_student', $student);
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
