<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App;

use RectorPrefix20210504\App\Playground\PlaygroundExample;
class BotComment extends \RectorPrefix20210504\App\Comment
{
    private string $resultHash;
    private string $diff;
    public function __construct(string $text, \RectorPrefix20210504\App\Playground\PlaygroundExample $playgroundExample, string $diff)
    {
        parent::__construct('phpstan-bot', $text, [$playgroundExample]);
        $this->resultHash = $playgroundExample->getHash();
        $this->diff = $diff;
    }
    public function getResultHash() : string
    {
        return $this->resultHash;
    }
    public function getDiff() : string
    {
        return $this->diff;
    }
}
