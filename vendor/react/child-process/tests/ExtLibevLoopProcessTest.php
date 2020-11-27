<?php

namespace _PhpScoper26e51eeacccf\React\Tests\ChildProcess;

use _PhpScoper26e51eeacccf\React\EventLoop\ExtLibevLoop;
use _PhpScoper26e51eeacccf\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScoper26e51eeacccf\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScoper26e51eeacccf\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScoper26e51eeacccf\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScoper26e51eeacccf\React\EventLoop\ExtLibevLoop() : new \_PhpScoper26e51eeacccf\React\EventLoop\LibEvLoop();
    }
}
