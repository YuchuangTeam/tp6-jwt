<?php


namespace cuarb\jwt;

use cuarb\jwt\claim\Factory;
use cuarb\jwt\claim\Issuer;
use cuarb\jwt\claim\Audience;
use cuarb\jwt\claim\Expiration;
use cuarb\jwt\claim\IssuedAt;
use cuarb\jwt\claim\JwtId;
use cuarb\jwt\claim\NotBefore;
use cuarb\jwt\claim\Subject;

class Payload
{
    protected $factory;

    protected $classMap
        = [
            'aud' => Audience::class,
            'exp' => Expiration::class,
            'iat' => IssuedAt::class,
            'iss' => Issuer::class,
            'jti' => JwtId::class,
            'nbf' => NotBefore::class,
            'sub' => Subject::class,
        ];

    protected $claims;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function customer(array $claim = [])
    {
        foreach ($claim as $key => $value) {
            $this->factory->customer(
                $key,
                is_object($value) ? $value->getValue() : $value
            );
        }

        return $this;
    }

    public function get()
    {
        $claim = $this->factory->builder()->getClaims();

        return $claim;
    }

    public function check($refresh = false)
    {
        $this->factory->validate($refresh);

        return $this;
    }
}
