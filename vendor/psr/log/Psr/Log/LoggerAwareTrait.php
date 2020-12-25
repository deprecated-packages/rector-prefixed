<?php

namespace _PhpScoper5b8c9e9ebd21\Psr\Log;

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
    public function setLogger(\_PhpScoper5b8c9e9ebd21\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
