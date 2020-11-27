<?php

namespace _PhpScoperbd5d0c5f7638\React\Tests\ChildProcess;

use _PhpScoperbd5d0c5f7638\React\EventLoop\ExtLibeventLoop;
use _PhpScoperbd5d0c5f7638\React\EventLoop\LibEventLoop;
class ExtLibeventLoopProcessTest extends \_PhpScoperbd5d0c5f7638\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\function_exists('event_base_new')) {
            $this->markTestSkipped('ext-libevent is not installed.');
        }
        return \class_exists('_PhpScoperbd5d0c5f7638\\React\\EventLoop\\ExtLibeventLoop') ? new \_PhpScoperbd5d0c5f7638\React\EventLoop\ExtLibeventLoop() : new \_PhpScoperbd5d0c5f7638\React\EventLoop\LibEventLoop();
    }
}
