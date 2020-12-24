<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Car
{
    /** @var CarType */
    private $carType;
    public function getCarType() : \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\CarType
    {
        return $this->carType;
    }
}
