<?php

namespace _PhpScoperbd5d0c5f7638\Psr\Log;

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
    public function setLogger(\_PhpScoperbd5d0c5f7638\Psr\Log\LoggerInterface $logger);
}
