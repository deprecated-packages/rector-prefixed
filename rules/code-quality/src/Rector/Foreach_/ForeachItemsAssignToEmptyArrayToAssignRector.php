<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\NodeFinder\NodeUsageFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\ForeachItemsAssignToEmptyArrayToAssignRectorTest
 */
final class ForeachItemsAssignToEmptyArrayToAssignRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NodeUsageFinder
     */
    private $nodeUsageFinder;
    /**
     * @var ForeachNodeAnalyzer
     */
    private $foreachNodeAnalyzer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder, \_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer $foreachNodeAnalyzer)
    {
        $this->nodeUsageFinder = $nodeUsageFinder;
        $this->foreachNodeAnalyzer = $foreachNodeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change foreach() items assign to empty array to direct assign', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
        $previousDeclarationParentNode = $previousDeclaration->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$previousDeclarationParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            return null;
        }
        // must be empty array, otherwise it will false override
        $defaultValue = $this->getValue($previousDeclarationParentNode->expr);
        if ($defaultValue !== []) {
            return null;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($assignVariable, $node->expr);
    }
    private function shouldSkipAsPartOfNestedForeach(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        $foreachParent = $this->betterNodeFinder->findFirstParentInstanceOf($foreach, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class);
        return $foreachParent !== null;
    }
}
