<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    public function match(string $rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
}
