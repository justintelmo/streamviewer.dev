<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

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
        $request->setTrustedProxies( [ $request->getClientIp() ], Request::HEADER_X_FORWARDED_ALL );

        if (!$request->secure() && App::environment() === "production") {
            return redirect()->secure($request->getRequestUri());
        }

        return next($request);
    }

}