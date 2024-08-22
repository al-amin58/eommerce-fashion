<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Properties;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            if (Auth::user()->type === Properties::$customer){
                return $next($request);
            }else{
                Auth::logout();
                return back()->withErrors([
                    "message" => "This Account Is Invalid."
                ]);
            }
        }else{
            return redirect()->route('customer.login');
        }
    }
}
