<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class PropertyFetchReadNodeAnalyzer extends \_PhpScoper0a2ac50786fa\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScoper0a2ac50786fa\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param PropertyFetch $node
     */
    public function isRead(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $propertyFetchUsages = $this->nodeUsageFinder->findPropertyFetchUsages($node);
        foreach ($propertyFetchUsages as $propertyFetchUsage) {
            if ($this->isCurrentContextRead($propertyFetchUsage)) {
                return \true;
            }
        }
        return \false;
    }
}
