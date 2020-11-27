<?php

namespace _PhpScoper006a73f0e455\Psr\Log;

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
    public function setLogger(\_PhpScoper006a73f0e455\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
