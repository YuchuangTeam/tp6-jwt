<?php
namespace cuarb\jwt\exception;

class TokenParseFailedException extends JWTException
{
    protected $message = 'token parse failed';
}
