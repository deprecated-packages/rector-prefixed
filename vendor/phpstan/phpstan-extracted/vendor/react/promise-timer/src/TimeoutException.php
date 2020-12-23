<?php

namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\React\Promise\Timer;

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
