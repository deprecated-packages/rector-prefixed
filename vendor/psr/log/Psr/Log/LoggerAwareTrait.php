<?php

namespace _PhpScoper8b9c402c5f32\Psr\Log;

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
    public function setLogger(\_PhpScoper8b9c402c5f32\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
