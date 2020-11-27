<?php

namespace _PhpScoper006a73f0e455\React\Tests\ChildProcess;

use _PhpScoper006a73f0e455\React\EventLoop\ExtLibevLoop;
use _PhpScoper006a73f0e455\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScoper006a73f0e455\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScoper006a73f0e455\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScoper006a73f0e455\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScoper006a73f0e455\React\EventLoop\ExtLibevLoop() : new \_PhpScoper006a73f0e455\React\EventLoop\LibEvLoop();
    }
}
