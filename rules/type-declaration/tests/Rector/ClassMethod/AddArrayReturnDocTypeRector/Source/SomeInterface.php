<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\Source;

interface SomeInterface
{
    /**
     * @return string[]
     */
    public function someMethod() : array;
}
