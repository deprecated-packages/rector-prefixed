<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source;

class ParentClassWithNewConstructor
{
    /**
     * @var int
     */
    private $defaultValue;
    public function __construct()
    {
        $this->defaultValue = 5;
    }
}
