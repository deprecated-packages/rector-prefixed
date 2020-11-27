<?php

namespace _PhpScoper006a73f0e455\React\Tests\ChildProcess;

use _PhpScoper006a73f0e455\React\EventLoop\ExtLibeventLoop;
use _PhpScoper006a73f0e455\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScoper006a73f0e455\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScoper006a73f0e455\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScoper006a73f0e455\React\EventLoop\ExtLibeventLoop() : new \_PhpScoper006a73f0e455\React\EventLoop\LibEventLoop();
    }
}
