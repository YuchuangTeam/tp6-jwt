<?php


namespace cuarb\jwt;

use cuarb\jwt\command\SecretCommand;
use cuarb\jwt\middleware\InjectJwt;
use cuarb\jwt\provider\JWT as JWTProvider;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands(SecretCommand::class);
        $this->app->middleware->add(InjectJwt::class);
    }
}
