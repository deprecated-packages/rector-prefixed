<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\ReadWrite\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool;
    public function isRead(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool;
}
