<?php

namespace _PhpScoper88fe6e0ad041\React\Tests\ChildProcess;

use _PhpScoper88fe6e0ad041\React\EventLoop\ExtEventLoop;
class ExtEventLoopProcessTest extends \_PhpScoper88fe6e0ad041\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\extension_loaded('event')) {
            $this->markTestSkipped('ext-event is not installed.');
        }
        if (!\class_exists('_PhpScoper88fe6e0ad041\\React\\EventLoop\\ExtEventLoop')) {
            $this->markTestSkipped('ext-event not supported by this legacy react/event-loop version');
        }
        return new \_PhpScoper88fe6e0ad041\React\EventLoop\ExtEventLoop();
    }
}
