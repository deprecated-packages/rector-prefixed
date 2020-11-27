<?php

namespace _PhpScoper26e51eeacccf\Psr\Log;

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
    public function setLogger(\_PhpScoper26e51eeacccf\Psr\Log\LoggerInterface $logger);
}
