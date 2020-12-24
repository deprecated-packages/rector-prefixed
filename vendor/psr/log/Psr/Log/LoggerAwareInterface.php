<?php

namespace _PhpScoper2a4e7ab1ecbc\Psr\Log;

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
    public function setLogger(\_PhpScoper2a4e7ab1ecbc\Psr\Log\LoggerInterface $logger);
}
