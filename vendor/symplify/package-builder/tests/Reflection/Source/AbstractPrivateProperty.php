<?php

declare (strict_types=1);
namespace RectorPrefix20210129\Symplify\PackageBuilder\Tests\Reflection\Source;

abstract class AbstractPrivateProperty
{
    /**
     * @var int
     */
    private $parentValue = 10;
    public function getParentValue() : int
    {
        return $this->parentValue;
    }
}
