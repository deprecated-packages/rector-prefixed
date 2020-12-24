<?php

namespace _PhpScoper2a4e7ab1ecbc\Psr\Log;

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
    public function setLogger(\_PhpScoper2a4e7ab1ecbc\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
