<?php

namespace _PhpScoper5b8c9e9ebd21\Psr\Log;

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
    public function setLogger(\_PhpScoper5b8c9e9ebd21\Psr\Log\LoggerInterface $logger);
}
