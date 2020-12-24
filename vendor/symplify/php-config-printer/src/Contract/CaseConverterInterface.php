<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
}
