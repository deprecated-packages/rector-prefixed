<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Driver
{
    /** @var Car */
    private $car;
    public function getCar() : \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\Car
    {
        return $this->car;
    }
}
