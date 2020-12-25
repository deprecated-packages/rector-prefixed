<?php

namespace _PhpScoper567b66d83109\Psr\Log;

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
    public function setLogger(\_PhpScoper567b66d83109\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
