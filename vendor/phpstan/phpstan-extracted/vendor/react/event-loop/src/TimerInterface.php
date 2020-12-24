<?php

namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\EventLoop;

interface TimerInterface
{
    /**
     * Get the interval after which this timer will execute, in seconds
     *
     * @return float
     */
    public function getInterval();
    /**
     * Get the callback that will be executed when this timer elapses
     *
     * @return callable
     */
    public function getCallback();
    /**
     * Determine whether the time is periodic
     *
     * @return bool
     */
    public function isPeriodic();
}