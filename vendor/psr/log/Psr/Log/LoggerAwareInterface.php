<?php

namespace _PhpScoper50d83356d739\Psr\Log;

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
    public function setLogger(\_PhpScoper50d83356d739\Psr\Log\LoggerInterface $logger);
}
