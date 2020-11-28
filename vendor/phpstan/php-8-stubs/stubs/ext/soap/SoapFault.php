<?php

namespace _PhpScoperabd03f0baf05;

class SoapFault extends \Exception
{
    public function __construct(array|string|null $code, string $string, ?string $actor = null, mixed $details = null, ?string $name = null, mixed $headerFault = null)
    {
    }
    public function __toString() : string
    {
    }
}
\class_alias('_PhpScoperabd03f0baf05\\SoapFault', 'SoapFault', \false);
