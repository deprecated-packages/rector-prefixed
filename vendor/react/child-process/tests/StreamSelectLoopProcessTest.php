<?php

namespace _PhpScoper006a73f0e455\React\Tests\ChildProcess;

use _PhpScoper006a73f0e455\React\EventLoop\StreamSelectLoop;
class StreamSelectLoopProcessTest extends \_PhpScoper006a73f0e455\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        return new \_PhpScoper006a73f0e455\React\EventLoop\StreamSelectLoop();
    }
}
