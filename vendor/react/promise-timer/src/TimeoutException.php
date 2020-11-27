<?php

namespace _PhpScoper88fe6e0ad041\React\Promise\Timer;

use RuntimeException;
class TimeoutException extends \RuntimeException
{
    private $timeout;
    public function __construct($timeout, $message = null, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->timeout = $timeout;
    }
    public function getTimeout()
    {
        return $this->timeout;
    }
}