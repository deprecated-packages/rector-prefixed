<?php

namespace _PhpScoper567b66d83109\Psr\Log;

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
    public function setLogger(\_PhpScoper567b66d83109\Psr\Log\LoggerInterface $logger);
}
