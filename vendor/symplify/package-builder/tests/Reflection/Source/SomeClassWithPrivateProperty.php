<?php

declare (strict_types=1);
namespace RectorPrefix20210313\Symplify\PackageBuilder\Tests\Reflection\Source;

final class SomeClassWithPrivateProperty extends \RectorPrefix20210313\Symplify\PackageBuilder\Tests\Reflection\Source\AbstractPrivateProperty
{
    /**
     * @var int
     */
    private $value = 5;
    public function getValue() : int
    {
        return $this->value;
    }
}
