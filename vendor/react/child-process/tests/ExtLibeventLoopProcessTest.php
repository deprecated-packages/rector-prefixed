<?php

namespace _PhpScoperabd03f0baf05\React\Tests\ChildProcess;

use _PhpScoperabd03f0baf05\React\EventLoop\ExtLibeventLoop;
use _PhpScoperabd03f0baf05\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScoperabd03f0baf05\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScoperabd03f0baf05\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScoperabd03f0baf05\React\EventLoop\ExtLibeventLoop() : new \_PhpScoperabd03f0baf05\React\EventLoop\LibEventLoop();
    }
}
