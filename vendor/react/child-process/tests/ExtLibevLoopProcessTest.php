<?php

namespace _PhpScoper88fe6e0ad041\React\Tests\ChildProcess;

use _PhpScoper88fe6e0ad041\React\EventLoop\ExtLibevLoop;
use _PhpScoper88fe6e0ad041\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScoper88fe6e0ad041\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScoper88fe6e0ad041\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScoper88fe6e0ad041\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScoper88fe6e0ad041\React\EventLoop\ExtLibevLoop() : new \_PhpScoper88fe6e0ad041\React\EventLoop\LibEvLoop();
    }
}
