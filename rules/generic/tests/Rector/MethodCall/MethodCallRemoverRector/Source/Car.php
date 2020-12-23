<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Car
{
    /** @var CarType */
    private $carType;
    public function getCarType() : \_PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\CarType
    {
        return $this->carType;
    }
}
