<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Privatization\Tests\Rector\Property\PrivatizeFinalClassPropertyRector\Source;

abstract class AbstractClassWithProtectedProperty
{
    /**
     * @var int
     */
    protected $value = 1000;
}
