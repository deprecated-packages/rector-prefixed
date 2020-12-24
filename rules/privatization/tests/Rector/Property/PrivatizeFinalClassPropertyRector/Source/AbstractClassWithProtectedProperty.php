<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Privatization\Tests\Rector\Property\PrivatizeFinalClassPropertyRector\Source;

abstract class AbstractClassWithProtectedProperty
{
    /**
     * @var int
     */
    protected $value = 1000;
}
