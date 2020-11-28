<?php

namespace _PhpScoperabd03f0baf05\React\Tests\ChildProcess;

use _PhpScoperabd03f0baf05\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScoperabd03f0baf05\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScoperabd03f0baf05\React\EventLoop\StreamSelectLoop();
    }
}
