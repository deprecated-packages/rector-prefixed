<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Foreach_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\ForeachItemsAssignToEmptyArrayToAssignRectorTest
 */
final class ForeachItemsAssignToEmptyArrayToAssignRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NodeUsageFinder
     */
    private $nodeUsageFinder;
    /**
     * @var ForeachNodeAnalyzer
     */
    private $foreachNodeAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder, \_PhpScoper0a2ac50786fa\Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer $foreachNodeAnalyzer)
    {
        $this->nodeUsageFinder = $nodeUsageFinder;
        $this->foreachNodeAnalyzer = $foreachNodeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change foreach() items assign to empty array to direct assign', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        foreach ($items as $item) {
             $collectedItems[] = $item;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        $collectedItems = $items;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $assignVariable = $this->foreachNodeAnalyzer->matchAssignItemsOnlyForeachArrayVariable($node);
        if ($assignVariable === null) {
            return null;
        }
        if ($this->shouldSkipAsPartOfNestedForeach($node)) {
            return null;
        }
        $previousDeclaration = $this->nodeUsageFinder->findPreviousForeachNodeUsage($node, $assignVariable);
        if ($previousDeclaration === null) {
            return null;
        }
        $previousDeclarationParentNode = $previousDeclaration->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$previousDeclarationParentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return null;
        }
        // must be empty array, otherwise it will false override
        $defaultValue = $this->getValue($previousDeclarationParentNode->expr);
        if ($defaultValue !== []) {
            return null;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($assignVariable, $node->expr);
    }
    private function shouldSkipAsPartOfNestedForeach(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        $foreachParent = $this->betterNodeFinder->findFirstParentInstanceOf($foreach, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class);
        return $foreachParent !== null;
    }
}
