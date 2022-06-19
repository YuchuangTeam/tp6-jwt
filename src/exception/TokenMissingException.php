<?php

namespace cuarb\jwt\exception;

class TokenMissingException extends JWTException
{
    protected $message = 'token missing';
}
