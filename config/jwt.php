<?php


return [
    'secret'      => env('JWT_SECRET',''),

    // 非对称密钥
    'public_key'  => env('JWT_PUBLIC_KEY',''),
    'private_key' => env('JWT_PRIVATE_KEY',''),
    'password'    => env('JWT_PASSWORD',''),

    // JWT 生存时间 单位分钟 60分钟
    'ttl'         => env('JWT_TTL', 60),

    // 刷新时间 单位分钟 14天(14天内可以刷新)
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),

    // JWT 哈希算法
    'algo'        => env('JWT_ALGO', 'HS256'),
    //'algo'        => env('JWT_ALGO', 'RS256'),

    // token获取方式，数组靠前值优先
    'token_mode'    => ['header', 'cookie', 'param'],

    // 黑名单后有效期
    'blacklist_grace_period' => env('BLACKLIST_GRACE_PERIOD', 10)
];
