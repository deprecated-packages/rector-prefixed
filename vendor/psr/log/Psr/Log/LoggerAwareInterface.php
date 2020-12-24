<?php

namespace _PhpScopere8e811afab72\Psr\Log;

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
    public function setLogger(\_PhpScopere8e811afab72\Psr\Log\LoggerInterface $logger);
}
