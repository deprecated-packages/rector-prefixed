<?php

namespace _PhpScoper88fe6e0ad041\Psr\Log;

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
    public function setLogger(\_PhpScoper88fe6e0ad041\Psr\Log\LoggerInterface $logger);
}
