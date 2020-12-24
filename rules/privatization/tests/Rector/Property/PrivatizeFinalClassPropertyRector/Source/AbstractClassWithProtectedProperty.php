<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Privatization\Tests\Rector\Property\PrivatizeFinalClassPropertyRector\Source;

abstract class AbstractClassWithProtectedProperty
{
    /**
     * @var int
     */
    protected $value = 1000;
}
