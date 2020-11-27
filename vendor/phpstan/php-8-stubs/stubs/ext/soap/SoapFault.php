<?php

namespace _PhpScopera143bcca66cb;

class SoapFault extends \Exception
{
    public function __construct(array|string|null $code, string $string, ?string $actor = null, mixed $details = null, ?string $name = null, mixed $headerFault = null)
    {
    }
    public function __toString() : string
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\SoapFault', 'SoapFault', \false);
