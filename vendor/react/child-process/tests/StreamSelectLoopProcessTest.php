<?php

namespace _PhpScoper26e51eeacccf\React\Tests\ChildProcess;

use _PhpScoper26e51eeacccf\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScoper26e51eeacccf\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScoper26e51eeacccf\React\EventLoop\StreamSelectLoop();
    }
}
