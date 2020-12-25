<?php

namespace _PhpScoper5edc98a7cce2\Psr\Log;

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
    public function setLogger(\_PhpScoper5edc98a7cce2\Psr\Log\LoggerInterface $logger);
}
