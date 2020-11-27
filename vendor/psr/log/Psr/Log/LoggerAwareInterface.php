<?php

namespace _PhpScoper006a73f0e455\Psr\Log;

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
    public function setLogger(\_PhpScoper006a73f0e455\Psr\Log\LoggerInterface $logger);
}
