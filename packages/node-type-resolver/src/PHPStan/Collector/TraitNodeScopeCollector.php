<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Collector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function addForTraitAndNode(string $traitName, \_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : void
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode) {
            return;
        }
        $traitNodeHash = $this->createHash($traitName, $node);
        // probably set from another class
        if (isset($this->scopeByTraitNodeHash[$traitNodeHash])) {
            return;
        }
        $this->scopeByTraitNodeHash[$traitNodeHash] = $scope;
    }
    public function getScopeForTraitAndNode(string $traitName, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        $traitNodeHash = $this->createHash($traitName, $node);
        return $this->scopeByTraitNodeHash[$traitNodeHash] ?? null;
    }
    private function createHash(string $traitName, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : string
    {
        $printedNode = $this->betterStandardPrinter->print($node);
        return \sha1($traitName . $printedNode);
    }
}
