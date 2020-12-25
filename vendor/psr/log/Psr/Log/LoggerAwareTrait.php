<?php

namespace _PhpScoperf18a0c41e2d2\Psr\Log;

/**
 * Basic Implementation of LoggerAwareInterface.
 */
trait LoggerAwareTrait
{
    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(\_PhpScoperf18a0c41e2d2\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
