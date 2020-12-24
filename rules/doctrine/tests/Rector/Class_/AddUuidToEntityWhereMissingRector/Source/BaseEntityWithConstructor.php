<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Tests\Rector\Class_\AddUuidToEntityWhereMissingRector\Source;

class BaseEntityWithConstructor
{
    private $items;
    public function __construct()
    {
        $this->items = [];
    }
}
