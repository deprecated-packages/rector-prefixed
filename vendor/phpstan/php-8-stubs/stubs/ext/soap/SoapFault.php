<?php

namespace _PhpScoperbd5d0c5f7638;

class SoapFault extends \Exception
{
    public function __construct(array|string|null $code, string $string, ?string $actor = null, mixed $details = null, ?string $name = null, mixed $headerFault = null)
    {
    }
    public function __toString() : string
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\SoapFault', 'SoapFault', \false);
