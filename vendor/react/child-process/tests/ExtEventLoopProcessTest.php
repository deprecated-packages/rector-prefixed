<?php

namespace _PhpScoper26e51eeacccf\React\Tests\ChildProcess;

use _PhpScoper26e51eeacccf\React\EventLoop\ExtEventLoop;
class ExtEventLoopProcessTest extends \_PhpScoper26e51eeacccf\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\extension_loaded('event')) {
            $this->markTestSkipped('ext-event is not installed.');
        }
        if (!\class_exists('_PhpScoper26e51eeacccf\\React\\EventLoop\\ExtEventLoop')) {
            $this->markTestSkipped('ext-event not supported by this legacy react/event-loop version');
        }
        return new \_PhpScoper26e51eeacccf\React\EventLoop\ExtEventLoop();
    }
}
