<?php


namespace cuarb\jwt\parser;

use cuarb\jwt\contract\Parser as ParserContract;
use think\Request;
use think\facade\Cookie as ThinkCookie;

class Cookie implements ParserContract
{
    use KeyTrait;

    public function parse(Request $request)
    {
        return ThinkCookie::get($this->key);
    }
}
