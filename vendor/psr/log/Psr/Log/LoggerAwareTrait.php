<?php

namespace _PhpScopera143bcca66cb\Psr\Log;

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
    public function setLogger(\_PhpScopera143bcca66cb\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
