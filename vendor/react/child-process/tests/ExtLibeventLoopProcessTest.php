<?php

namespace _PhpScoper26e51eeacccf\React\Tests\ChildProcess;

use _PhpScoper26e51eeacccf\React\EventLoop\ExtLibeventLoop;
use _PhpScoper26e51eeacccf\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScoper26e51eeacccf\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScoper26e51eeacccf\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScoper26e51eeacccf\React\EventLoop\ExtLibeventLoop() : new \_PhpScoper26e51eeacccf\React\EventLoop\LibEventLoop();
    }
}
