<?php

declare (strict_types=1);
namespace RectorPrefix20210113\Symplify\PhpConfigPrinter\Contract;

use PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \PhpParser\Node\Stmt\Expression;
}
