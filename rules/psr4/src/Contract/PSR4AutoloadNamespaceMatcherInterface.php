<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PSR4\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string;
}
