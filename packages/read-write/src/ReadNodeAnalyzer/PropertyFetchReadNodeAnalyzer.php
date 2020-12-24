<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ReadWrite\ReadNodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class PropertyFetchReadNodeAnalyzer extends \_PhpScoperb75b35f52b74\Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \_PhpScoperb75b35f52b74\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param PropertyFetch $node
     */
    public function isRead(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
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
