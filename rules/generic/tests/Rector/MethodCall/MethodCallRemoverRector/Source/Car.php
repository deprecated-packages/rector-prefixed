<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Car
{
    /** @var CarType */
    private $carType;
    public function getCarType() : \Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\CarType
    {
        return $this->carType;
    }
}
