<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\FlowControl;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Variable[] $assignedVariables
     * @return Variable[]
     */
    public function resolveUsedVariables(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $assignedVariables) : array
    {
        return $this->betterNodeFinder->find($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($assignedVariables) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // is the left assign - not use of one
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && ($parentNode->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && $parentNode->var === $node)) {
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
