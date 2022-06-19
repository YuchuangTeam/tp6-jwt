<?php


namespace cuarb\jwt\provider;

use cuarb\jwt\facade\JWTAuth;
use cuarb\jwt\parser\AuthHeader;
use cuarb\jwt\parser\Cookie;
use cuarb\jwt\parser\Param;
use think\App;
use think\Container;
use think\facade\Config;
use think\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

class JWT
{
    private $request;

    private $config;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $config        = require __DIR__.'/../../config/config.php';
        if (strpos(App::VERSION, '6.0') !== false) {
            $this->config = array_merge($config, Config::get('jwt') ?? []);
        } else {
            $this->config = array_merge($config, Config::get('jwt.') ?? []);
        }
    }

    protected function registerBlacklist()
    {
        Container::getInstance()->make('cuarb\jwt\Blacklist', [
            new $this->config['blacklist_storage'],
        ])->setRefreshTTL($this->config['refresh_ttl'])->setGracePeriod($this->config['blacklist_grace_period']);
    }


    protected function registerProvider()
    {
        //builder asymmetric keys
        $keys = $this->config['secret']
            ? $this->config['secret']
            : [
                'public'   => $this->config['public_key'],
                'private'  => $this->config['private_key'],
                'password' => $this->config['password'],
            ];
        Container::getInstance()->make('cuarb\jwt\provider\JWT\Lcobucci', [
            new Builder(),
            new Parser(),
            $this->config['algo'],
            $keys,
        ]);
    }

    protected function registerFactory()
    {
        Container::getInstance()->make('cuarb\jwt\claim\Factory', [
            new Request(),
            $this->config['ttl'],
            $this->config['refresh_ttl'],
        ]);
    }

    protected function registerPayload()
    {
        Container::getInstance()->make('cuarb\jwt\Payload', [
            Container::getInstance()->make('cuarb\jwt\claim\Factory'),
        ]);
    }

    protected function registerManager()
    {
        Container::getInstance()->make('cuarb\jwt\Manager', [
            Container::getInstance()->make('cuarb\jwt\Blacklist'),
            Container::getInstance()->make('cuarb\jwt\Payload'),
            Container::getInstance()->make('cuarb\jwt\provider\JWT\Lcobucci'),
        ]);
    }

    protected function registerJWTAuth()
    {
        $chains = [
            'header' => new AuthHeader(),
            'cookie' => new Cookie(),
            'param'  => new Param()
        ];

        $mode = $this->config['token_mode'];
        $setChain = [];

        foreach ($mode as $key => $chain) {
            if (isset($chains[$chain])) {
                $setChain[$key] = $chains[$chain];
            }
        }

        JWTAuth::parser()->setRequest($this->request)->setChain($setChain);
    }

    public function init()
    {
        $this->registerBlacklist();
        $this->registerProvider();
        $this->registerFactory();
        $this->registerPayload();
        $this->registerManager();
        $this->registerJWTAuth();
    }
}
