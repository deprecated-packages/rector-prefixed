<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source;

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
