<?php

namespace _PhpScoperfce0de0de1ce\Psr\Log;

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
    public function setLogger(\_PhpScoperfce0de0de1ce\Psr\Log\LoggerInterface $logger);
}
