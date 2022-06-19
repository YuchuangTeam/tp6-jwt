<?php


namespace cuarb\jwt\parser;

trait KeyTrait
{
    private $key = 'token';

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }
}
