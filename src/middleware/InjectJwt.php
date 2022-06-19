<?php


namespace cuarb\jwt\middleware;

use think\Request;
use cuarb\jwt\provider\JWT as JWTProvider;

class InjectJwt
{
    public function handle(Request $request, $next)
    {
        (new JWTProvider($request))->init();
        $response = $next($request);
        return $response;
    }
}
