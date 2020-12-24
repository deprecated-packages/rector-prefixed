<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    public function match(string $key, $values) : bool;
    public function convertToMethodCall(string $key, $values) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
}
