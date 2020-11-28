<?php

namespace _PhpScoperabd03f0baf05\Psr\Log;

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
    public function setLogger(\_PhpScoperabd03f0baf05\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
