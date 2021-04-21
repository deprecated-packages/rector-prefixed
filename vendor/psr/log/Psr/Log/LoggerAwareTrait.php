<?php

namespace RectorPrefix20210421\Psr\Log;

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
    public function setLogger(\RectorPrefix20210421\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
