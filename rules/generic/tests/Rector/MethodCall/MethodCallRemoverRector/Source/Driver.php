<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Driver
{
    /** @var Car */
    private $car;
    public function getCar() : \Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\Car
    {
        return $this->car;
    }
}
