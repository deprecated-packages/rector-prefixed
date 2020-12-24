<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class PropertyFetchReadNodeAnalyzer extends \_PhpScoper0a6b37af0871\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScoper0a6b37af0871\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param PropertyFetch $node
     */
    public function isRead(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
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
