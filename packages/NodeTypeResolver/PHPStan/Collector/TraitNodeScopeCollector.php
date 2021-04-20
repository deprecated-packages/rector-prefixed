<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan\Collector;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\VirtualNode;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class TraitNodeScopeCollector
{
    /**
     * @var array<string, Scope>
     */
    private $scopeByTraitNodeHash = [];
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return void
     */
    public function addForTraitAndNode(string $traitName, \PhpParser\Node $node, \PHPStan\Analyser\Scope $scope)
    {
        if ($node instanceof \PHPStan\Node\VirtualNode) {
            return;
        }
        $traitNodeHash = $this->createHash($traitName, $node);
        // probably set from another class
        if (isset($this->scopeByTraitNodeHash[$traitNodeHash])) {
            return;
        }
        $this->scopeByTraitNodeHash[$traitNodeHash] = $scope;
    }
    /**
     * @return \PHPStan\Analyser\Scope|null
     */
    public function getScopeForTraitAndNode(string $traitName, \PhpParser\Node $node)
    {
        $traitNodeHash = $this->createHash($traitName, $node);
        return $this->scopeByTraitNodeHash[$traitNodeHash] ?? null;
    }
    private function createHash(string $traitName, \PhpParser\Node $node) : string
    {
        $printedNode = $this->betterStandardPrinter->print($node);
        return \sha1($traitName . $printedNode);
    }
}
