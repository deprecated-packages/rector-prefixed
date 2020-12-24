<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PSR4\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string;
}
