<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CORS {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === "production") {
            return redirect()->secure($request->getRequestUri());
        }

        return next($request);
    }

}