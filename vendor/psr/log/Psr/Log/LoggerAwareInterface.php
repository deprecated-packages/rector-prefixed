<?php

namespace _PhpScoperf18a0c41e2d2\Psr\Log;

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
    public function setLogger(\_PhpScoperf18a0c41e2d2\Psr\Log\LoggerInterface $logger);
}
