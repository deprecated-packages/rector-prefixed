<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PSR4\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string;
}
