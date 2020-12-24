<?php

namespace _PhpScoperb75b35f52b74\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(\_PhpScoperb75b35f52b74\Psr\Log\LoggerInterface $logger);
}
