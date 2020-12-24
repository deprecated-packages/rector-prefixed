<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\FlowControl;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Variable[] $assignedVariables
     * @return Variable[]
     */
    public function resolveUsedVariables(\_PhpScopere8e811afab72\PhpParser\Node $node, array $assignedVariables) : array
    {
        return $this->betterNodeFinder->find($node, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($assignedVariables) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // is the left assign - not use of one
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && ($parentNode->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable && $parentNode->var === $node)) {
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
