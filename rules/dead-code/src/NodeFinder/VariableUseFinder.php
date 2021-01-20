<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableUseFinder
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Variable[] $assignedVariables
     * @return Variable[]
     */
    public function resolveUsedVariables(\PhpParser\Node $node, array $assignedVariables) : array
    {
        return $this->betterNodeFinder->find($node, function (\PhpParser\Node $node) use($assignedVariables) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // is the left assign - not use of one
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign && ($parentNode->var instanceof \PhpParser\Node\Expr\Variable && $parentNode->var === $node)) {
                return \false;
            }
            $nodeNameResolverGetName = $this->nodeNameResolver->getName($node);
            // simple variable only
            if ($nodeNameResolverGetName === null) {
                return \false;
            }
            return $this->betterStandardPrinter->isNodeEqual($node, $assignedVariables);
        });
    }
}
