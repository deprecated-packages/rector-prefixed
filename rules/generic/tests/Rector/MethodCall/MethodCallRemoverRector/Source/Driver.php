<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source;

final class Driver
{
    /** @var Car */
    private $car;
    public function getCar() : \_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\MethodCall\MethodCallRemoverRector\Source\Car
    {
        return $this->car;
    }
}
