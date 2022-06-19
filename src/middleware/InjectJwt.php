<?php


namespace cuarb\jwt\middleware;

use think\Request;
use cuarb\jwt\provider\JWT as JWTProvider;

class InjectJwt
{
    public function handle(Request $request, $next)
    {
        (new JWTProvider)->init();

        return $next($request);
    }
}
