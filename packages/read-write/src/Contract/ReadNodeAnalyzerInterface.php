<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ReadWrite\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool;
    public function isRead(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool;
}
