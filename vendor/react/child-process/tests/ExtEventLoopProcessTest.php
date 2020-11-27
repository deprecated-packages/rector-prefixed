<?php

namespace _PhpScoperbd5d0c5f7638\React\Tests\ChildProcess;

use _PhpScoperbd5d0c5f7638\React\EventLoop\ExtEventLoop;
class ExtEventLoopProcessTest extends \_PhpScoperbd5d0c5f7638\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\extension_loaded('event')) {
            $this->markTestSkipped('ext-event is not installed.');
        }
        if (!\class_exists('_PhpScoperbd5d0c5f7638\\React\\EventLoop\\ExtEventLoop')) {
            $this->markTestSkipped('ext-event not supported by this legacy react/event-loop version');
        }
        return new \_PhpScoperbd5d0c5f7638\React\EventLoop\ExtEventLoop();
    }
}
