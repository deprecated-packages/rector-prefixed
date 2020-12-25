<?php

namespace _HumbugBox221ad6f1b81f\Psr\Log;

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
    public function setLogger(\_HumbugBox221ad6f1b81f\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
