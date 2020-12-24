<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Car
{
    /** @var CarType */
    private $carType;
    public function getCarType() : \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\CarType
    {
        return $this->carType;
    }
}
