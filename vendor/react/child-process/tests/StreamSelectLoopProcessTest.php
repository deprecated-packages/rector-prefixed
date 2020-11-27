<?php

namespace _PhpScoperbd5d0c5f7638\React\Tests\ChildProcess;

use _PhpScoperbd5d0c5f7638\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScoperbd5d0c5f7638\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScoperbd5d0c5f7638\React\EventLoop\StreamSelectLoop();
    }
}
