<?php

namespace _PhpScoperbf340cb0be9d\Psr\Log;

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
    public function setLogger(\_PhpScoperbf340cb0be9d\Psr\Log\LoggerInterface $logger);
}
