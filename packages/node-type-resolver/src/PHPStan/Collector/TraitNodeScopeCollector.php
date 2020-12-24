<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\VirtualNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class TraitNodeScopeCollector
{
    /**
     * @var Scope[]
     */
    private $scopeByTraitNodeHash = [];
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function addForTraitAndNode(string $traitName, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode) {
            return;
        }
        $traitNodeHash = $this->createHash($traitName, $node);
        // probably set from another class
        if (isset($this->scopeByTraitNodeHash[$traitNodeHash])) {
            return;
        }
        $this->scopeByTraitNodeHash[$traitNodeHash] = $scope;
    }
    public function getScopeForTraitAndNode(string $traitName, \_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        $traitNodeHash = $this->createHash($traitName, $node);
        return $this->scopeByTraitNodeHash[$traitNodeHash] ?? null;
    }
    private function createHash(string $traitName, \_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        $printedNode = $this->betterStandardPrinter->print($node);
        return \sha1($traitName . $printedNode);
    }
}
