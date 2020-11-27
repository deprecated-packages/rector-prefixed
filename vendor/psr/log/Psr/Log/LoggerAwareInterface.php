<?php

namespace _PhpScopera143bcca66cb\Psr\Log;

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
    public function setLogger(\_PhpScopera143bcca66cb\Psr\Log\LoggerInterface $logger);
}
