<?php

namespace _PhpScoper88fe6e0ad041\React\Tests\ChildProcess;

use _PhpScoper88fe6e0ad041\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScoper88fe6e0ad041\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScoper88fe6e0ad041\React\EventLoop\StreamSelectLoop();
    }
}
