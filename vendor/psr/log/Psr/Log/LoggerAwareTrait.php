<?php

namespace _PhpScoper26e51eeacccf\Psr\Log;

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
    public function setLogger(\_PhpScoper26e51eeacccf\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
