<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array;
}
