<?php

namespace _PhpScopera143bcca66cb\React\Tests\ChildProcess;

use _PhpScopera143bcca66cb\React\EventLoop\ExtLibevLoop;
use _PhpScopera143bcca66cb\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScopera143bcca66cb\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScopera143bcca66cb\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScopera143bcca66cb\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScopera143bcca66cb\React\EventLoop\ExtLibevLoop() : new \_PhpScopera143bcca66cb\React\EventLoop\LibEvLoop();
    }
}
