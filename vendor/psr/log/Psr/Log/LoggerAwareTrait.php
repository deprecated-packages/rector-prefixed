<?php

namespace _PhpScoperbd5d0c5f7638\Psr\Log;

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
    public function setLogger(\_PhpScoperbd5d0c5f7638\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
