<?php


namespace cuarb\jwt\claim;

use cuarb\jwt\exception\TokenExpiredException;

class Expiration extends Claim
{
    protected string $name = 'exp';

    /**
     * @throws TokenExpiredException
     */
    public function validatePayload()
    {
        if (time() >= $this->getValue()->getTimeStamp()) {
            throw new TokenExpiredException('The token is expired.');
        }
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
