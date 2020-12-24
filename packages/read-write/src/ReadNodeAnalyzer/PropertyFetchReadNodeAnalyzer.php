<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class PropertyFetchReadNodeAnalyzer extends \_PhpScopere8e811afab72\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScopere8e811afab72\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param PropertyFetch $node
     */
    public function isRead(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
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
