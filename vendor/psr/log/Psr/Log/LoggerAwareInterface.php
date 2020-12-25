<?php

namespace _PhpScoper17db12703726\Psr\Log;

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
    public function setLogger(\_PhpScoper17db12703726\Psr\Log\LoggerInterface $logger);
}
