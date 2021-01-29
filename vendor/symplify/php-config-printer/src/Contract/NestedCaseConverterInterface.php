<?php

declare (strict_types=1);
namespace RectorPrefix20210129\Symplify\PhpConfigPrinter\Contract;

use PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression;
}
