<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Collector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function addForTraitAndNode(string $traitName, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode) {
            return;
        }
        $traitNodeHash = $this->createHash($traitName, $node);
        // probably set from another class
        if (isset($this->scopeByTraitNodeHash[$traitNodeHash])) {
            return;
        }
        $this->scopeByTraitNodeHash[$traitNodeHash] = $scope;
    }
    public function getScopeForTraitAndNode(string $traitName, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        $traitNodeHash = $this->createHash($traitName, $node);
        return $this->scopeByTraitNodeHash[$traitNodeHash] ?? null;
    }
    private function createHash(string $traitName, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : string
    {
        $printedNode = $this->betterStandardPrinter->print($node);
        return \sha1($traitName . $printedNode);
    }
}
