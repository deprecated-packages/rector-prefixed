<?php

namespace _PhpScoper88fe6e0ad041\React\Tests\ChildProcess;

use _PhpScoper88fe6e0ad041\React\EventLoop\ExtLibeventLoop;
use _PhpScoper88fe6e0ad041\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScoper88fe6e0ad041\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScoper88fe6e0ad041\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScoper88fe6e0ad041\React\EventLoop\ExtLibeventLoop() : new \_PhpScoper88fe6e0ad041\React\EventLoop\LibEventLoop();
    }
}
