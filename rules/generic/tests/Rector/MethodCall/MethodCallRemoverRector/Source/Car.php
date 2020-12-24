<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Car
{
    /** @var CarType */
    private $carType;
    public function getCarType() : \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\CarType
    {
        return $this->carType;
    }
}
