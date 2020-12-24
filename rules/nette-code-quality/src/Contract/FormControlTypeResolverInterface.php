<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array;
}
