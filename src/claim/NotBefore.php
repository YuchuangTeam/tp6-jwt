<?php


namespace cuarb\jwt\claim;

class NotBefore extends Claim
{
    protected string $name = 'nbf';

    public function getValue(): mixed
    {
        return $this->value;
    }
}
