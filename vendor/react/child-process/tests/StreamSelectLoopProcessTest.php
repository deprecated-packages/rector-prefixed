<?php

namespace _PhpScopera143bcca66cb\React\Tests\ChildProcess;

use _PhpScopera143bcca66cb\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScopera143bcca66cb\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScopera143bcca66cb\React\EventLoop\StreamSelectLoop();
    }
}
