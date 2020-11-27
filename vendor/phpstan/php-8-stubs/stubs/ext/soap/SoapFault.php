<?php

namespace _PhpScoper26e51eeacccf;

class SoapFault extends \Exception
{
    public function __construct(array|string|null $code, string $string, ?string $actor = null, mixed $details = null, ?string $name = null, mixed $headerFault = null)
    {
    }
    public function __toString() : string
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\SoapFault', 'SoapFault', \false);
