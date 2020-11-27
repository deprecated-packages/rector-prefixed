<?php

namespace _PhpScoperbd5d0c5f7638\React\Tests\ChildProcess;

use _PhpScoperbd5d0c5f7638\React\EventLoop\ExtLibevLoop;
use _PhpScoperbd5d0c5f7638\React\EventLoop\LibEvLoop;
class ExtLibevLoopProcessTest extends \_PhpScoperbd5d0c5f7638\React\Tests\ChildProcess\AbstractProcessTest
{
    public function createLoop()
    {
        if (!\class_exists('_PhpScoperbd5d0c5f7638\\libev\\EventLoop')) {
            $this->markTestSkipped('ext-libev is not installed.');
        }
        return \class_exists('_PhpScoperbd5d0c5f7638\\React\\EventLoop\\ExtLibevLoop') ? new \_PhpScoperbd5d0c5f7638\React\EventLoop\ExtLibevLoop() : new \_PhpScoperbd5d0c5f7638\React\EventLoop\LibEvLoop();
    }
}
