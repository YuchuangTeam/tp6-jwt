<?php


namespace cb\jwt\middleware;

use think\Request;
use cb\jwt\provider\JWT as JWTProvider;

class InjectJwt
{
    public function handle(Request $request, $next)
    {
        (new JWTProvider($request))->init();
        $response = $next($request);
        return $response;
    }
}
