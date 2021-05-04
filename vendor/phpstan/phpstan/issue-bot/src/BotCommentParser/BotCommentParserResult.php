<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\BotCommentParser;

class BotCommentParserResult
{
    private string $hash;
    private string $diff;
    public function __construct(string $hash, string $diff)
    {
        $this->hash = $hash;
        $this->diff = $diff;
    }
    public function getHash() : string
    {
        return $this->hash;
    }
    public function getDiff() : string
    {
        return $this->diff;
    }
}
