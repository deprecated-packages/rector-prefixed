<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Privatization\Tests\Rector\Property\PrivatizeFinalClassPropertyRector\Source;

abstract class AbstractClassWithProtectedProperty
{
    /**
     * @var int
     */
    protected $value = 1000;
}
