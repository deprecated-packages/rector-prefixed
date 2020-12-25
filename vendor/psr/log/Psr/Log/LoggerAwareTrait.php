<?php

namespace _PhpScoperfce0de0de1ce\Psr\Log;

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
    public function setLogger(\_PhpScoperfce0de0de1ce\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
