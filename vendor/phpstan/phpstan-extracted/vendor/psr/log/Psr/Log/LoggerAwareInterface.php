<?php

namespace _HumbugBox221ad6f1b81f\Psr\Log;

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
    public function setLogger(\_HumbugBox221ad6f1b81f\Psr\Log\LoggerInterface $logger);
}
