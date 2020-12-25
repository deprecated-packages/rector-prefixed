<?php

namespace _PhpScoper8b9c402c5f32\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(\_PhpScoper8b9c402c5f32\Psr\Log\LoggerInterface $logger);
}
