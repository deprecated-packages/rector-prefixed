<?php

namespace _PhpScopera143bcca66cb\React\Tests\ChildProcess;

use _PhpScopera143bcca66cb\React\EventLoop\ExtEventLoop;
class ExtEventLoopProcessTest extends \_PhpScopera143bcca66cb\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\extension_loaded('event')) {
            $this->markTestSkipped('ext-event is not installed.');
        }
        if (!\class_exists('_PhpScopera143bcca66cb\\React\\EventLoop\\ExtEventLoop')) {
            $this->markTestSkipped('ext-event not supported by this legacy react/event-loop version');
        }
        return new \_PhpScopera143bcca66cb\React\EventLoop\ExtEventLoop();
    }
}
