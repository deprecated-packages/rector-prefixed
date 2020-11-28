<?php

namespace _PhpScoperabd03f0baf05\React\Tests\ChildProcess;

use _PhpScoperabd03f0baf05\React\EventLoop\ExtLibevLoop;
use _PhpScoperabd03f0baf05\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScoperabd03f0baf05\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScoperabd03f0baf05\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScoperabd03f0baf05\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScoperabd03f0baf05\React\EventLoop\ExtLibevLoop() : new \_PhpScoperabd03f0baf05\React\EventLoop\LibEvLoop();
    }
}
