<?php

namespace cuarb\jwt;

use cuarb\jwt\command\JwtCommand;
use cuarb\jwt\provider\JWT as JWTProvider;

class JwtService extends \think\Service
{
    public function boot()
    {
        $this->commands(JwtCommand::class);

        (new JWTProvider())->register();
    }
}
