<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Tests\Rector\Class_\AddUuidToEntityWhereMissingRector\Source;

class BaseEntityWithConstructor
{
    private $items;
    public function __construct()
    {
        $this->items = [];
    }
}
