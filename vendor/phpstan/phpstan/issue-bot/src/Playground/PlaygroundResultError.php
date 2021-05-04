<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\Playground;

class PlaygroundResultError
{
    private string $message;
    private int $line;
    public function __construct(string $message, int $line)
    {
        $this->message = $message;
        $this->line = $line;
    }
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
}
