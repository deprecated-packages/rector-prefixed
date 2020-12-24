<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

interface SomeInterface
{
    /**
     * @return string[]
     */
    public function someMethod() : array;
}
