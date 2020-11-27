<?php

declare (strict_types=1);
namespace Rector\ReadWrite\ReadNodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class PropertyFetchReadNodeAnalyzer extends \Rector\ReadWrite\ReadNodeAnalyzer\AbstractReadNodeAnalyzer implements \Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    public function supports(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param PropertyFetch $node
     */
    public function isRead(\PhpParser\Node $node) : bool
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
