<?php


namespace cb\jwt;

use cb\jwt\command\SecretCommand;
use cb\jwt\middleware\InjectJwt;
use cb\jwt\provider\JWT as JWTProvider;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands(SecretCommand::class);
        $this->app->middleware->add(InjectJwt::class);
    }
}
