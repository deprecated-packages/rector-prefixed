<?php

namespace _PhpScopera143bcca66cb\React\Tests\ChildProcess;

use _PhpScopera143bcca66cb\React\EventLoop\ExtLibeventLoop;
use _PhpScopera143bcca66cb\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScopera143bcca66cb\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScopera143bcca66cb\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScopera143bcca66cb\React\EventLoop\ExtLibeventLoop() : new \_PhpScopera143bcca66cb\React\EventLoop\LibEventLoop();
    }
}
