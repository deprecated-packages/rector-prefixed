<?php

namespace _PhpScoperbf340cb0be9d\Psr\Log;

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
    public function setLogger(\_PhpScoperbf340cb0be9d\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
