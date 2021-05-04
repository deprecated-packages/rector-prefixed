<?php

declare (strict_types=1);
namespace PHPStan\E2E;

use PhpParser\Node\Scalar\String_;
class PharAutoloaderWorks
{
    public function __construct(\PhpParser\Node\Scalar\String_ $string)
    {
        unset($string);
    }
}
new \PHPStan\E2E\PharAutoloaderWorks(new \PhpParser\Node\Scalar\String_(''));
