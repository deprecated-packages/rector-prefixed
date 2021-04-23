<?php

declare (strict_types=1);
namespace Rector\ReadWrite\ReadNodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
use Rector\ReadWrite\NodeFinder\NodeUsageFinder;
final class PropertyFetchReadNodeAnalyzer implements \Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface
{
    /**
     * @var ReadExprAnalyzer
     */
    private $readExprAnalyzer;
    /**
     * @var NodeUsageFinder
     */
    private $nodeUsageFinder;
    public function __construct(\Rector\ReadWrite\ReadNodeAnalyzer\ReadExprAnalyzer $readExprAnalyzer, \Rector\ReadWrite\NodeFinder\NodeUsageFinder $nodeUsageFinder)
    {
        $this->readExprAnalyzer = $readExprAnalyzer;
        $this->nodeUsageFinder = $nodeUsageFinder;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function supports($node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\PropertyFetch;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function isRead($node) : bool
    {
        $propertyFetchUsages = $this->nodeUsageFinder->findPropertyFetchUsages($node);
        foreach ($propertyFetchUsages as $propertyFetchUsage) {
            if ($this->readExprAnalyzer->isReadContext($propertyFetchUsage)) {
                return \true;
            }
        }
        return \false;
    }
}
