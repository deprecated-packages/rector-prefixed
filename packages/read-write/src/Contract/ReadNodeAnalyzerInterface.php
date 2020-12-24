<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ReadWrite\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool;
    public function isRead(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool;
}
