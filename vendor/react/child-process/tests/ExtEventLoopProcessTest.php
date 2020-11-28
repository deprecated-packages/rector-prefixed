<?php

namespace _PhpScoperabd03f0baf05\React\Tests\ChildProcess;

use _PhpScoperabd03f0baf05\React\EventLoop\ExtEventLoop;
class ExtEventLoopProcessTest extends \_PhpScoperabd03f0baf05\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\extension_loaded('event')) {
            $this->markTestSkipped('ext-event is not installed.');
        }
        if (!\class_exists('_PhpScoperabd03f0baf05\\React\\EventLoop\\ExtEventLoop')) {
            $this->markTestSkipped('ext-event not supported by this legacy react/event-loop version');
        }
        return new \_PhpScoperabd03f0baf05\React\EventLoop\ExtEventLoop();
    }
}
