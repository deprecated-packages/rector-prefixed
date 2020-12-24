<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\Rector\Core\Context\ContextAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\DeadCode\FlowControl\VariableUseFinder;
use _PhpScoperb75b35f52b74\Rector\DeadCode\NodeCollector\NodeByTypeAndPositionCollector;
use _PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveOverriddenValuesRector\RemoveOverriddenValuesRectorTest
 */
final class RemoveOverriddenValuesRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ContextAnalyzer
     */
    private $contextAnalyzer;
    /**
     * @var NodeByTypeAndPositionCollector
     */
    private $nodeByTypeAndPositionCollector;
    /**
     * @var VariableUseFinder
     */
    private $variableUseFinder;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Context\ContextAnalyzer $contextAnalyzer, \_PhpScoperb75b35f52b74\Rector\DeadCode\NodeCollector\NodeByTypeAndPositionCollector $nodeByTypeAndPositionCollector, \_PhpScoperb75b35f52b74\Rector\DeadCode\FlowControl\VariableUseFinder $variableUseFinder)
    {
        $this->contextAnalyzer = $contextAnalyzer;
        $this->nodeByTypeAndPositionCollector = $nodeByTypeAndPositionCollector;
        $this->variableUseFinder = $variableUseFinder;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove initial assigns of overridden values', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function run()
    {
         $directories = [];
         $possibleDirectories = [];
         $directories = array_filter($possibleDirectories, 'file_exists');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function run()
    {
         $possibleDirectories = [];
         $directories = array_filter($possibleDirectories, 'file_exists');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class];
    }
    /**
     * @param FunctionLike $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // 1. collect assigns
        $assignedVariables = $this->resolveAssignedVariables($node);
        $assignedVariableNames = $this->getNodeNames($assignedVariables);
        // 2. collect use of those variables
        $assignedVariablesUse = $this->variableUseFinder->resolveUsedVariables($node, $assignedVariables);
        $nodesByTypeAndPosition = $this->nodeByTypeAndPositionCollector->collectNodesByTypeAndPosition($assignedVariables, $assignedVariablesUse, $node);
        $nodesToRemove = $this->resolveNodesToRemove($assignedVariableNames, $nodesByTypeAndPosition);
        if ($nodesToRemove === []) {
            return null;
        }
        $this->removeNodes($nodesToRemove);
        return $node;
    }
    /**
     * @return Variable[]
     */
    private function resolveAssignedVariables(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        return $this->betterNodeFinder->find($functionLike, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            // skin in if
            if ($this->contextAnalyzer->isInIf($node)) {
                return \false;
            }
            // is variable on the left
            /** @var Assign $assignNode */
            $assignNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($assignNode->var !== $node) {
                return \false;
            }
            // simple variable only
            return \is_string($node->name);
        });
    }
    /**
     * @param Node[] $nodes
     * @return string[]
     */
    private function getNodeNames(array $nodes) : array
    {
        $nodeNames = [];
        foreach ($nodes as $node) {
            $nodeName = $this->getName($node);
            if ($nodeName) {
                $nodeNames[] = $nodeName;
            }
        }
        return \array_unique($nodeNames);
    }
    /**
     * @param string[] $assignedVariableNames
     * @param VariableNodeUse[] $nodesByTypeAndPosition
     * @return Node[]
     */
    private function resolveNodesToRemove(array $assignedVariableNames, array $nodesByTypeAndPosition) : array
    {
        $nodesToRemove = [];
        foreach ($assignedVariableNames as $assignedVariableName) {
            /** @var VariableNodeUse|null $previousNode */
            $previousNode = null;
            foreach ($nodesByTypeAndPosition as $nodeByTypeAndPosition) {
                if (!$nodeByTypeAndPosition->isName($assignedVariableName)) {
                    continue;
                }
                if ($this->isAssignNodeUsed($previousNode, $nodeByTypeAndPosition)) {
                    // continue
                    // instant override → remove
                } elseif ($this->shouldRemoveAssignNode($previousNode, $nodeByTypeAndPosition)) {
                    /** @var VariableNodeUse $previousNode */
                    $nodesToRemove[] = $previousNode->getParentNode();
                }
                $previousNode = $nodeByTypeAndPosition;
            }
        }
        return $nodesToRemove;
    }
    private function isAssignNodeUsed(?\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $previousNode, \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $nodeByTypeAndPosition) : bool
    {
        // this node was just used, skip to next one
        if ($previousNode === null) {
            return \false;
        }
        if (!$previousNode->isType(\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
            return \false;
        }
        return $nodeByTypeAndPosition->isType(\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_USE);
    }
    private function shouldRemoveAssignNode(?\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $previousNode, \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $nodeByTypeAndPosition) : bool
    {
        if ($previousNode === null) {
            return \false;
        }
        if (!$previousNode->isType(\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
            return \false;
        }
        if (!$nodeByTypeAndPosition->isType(\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
            return \false;
        }
        // check the nesting level, e.g. call in if/while/else etc.
        if ($previousNode->getNestingHash() !== $nodeByTypeAndPosition->getNestingHash()) {
            return \false;
        }
        // check previous node doesn't contain the node on the right, e.g.
        // $someNode = 1;
        // $someNode = $someNode ?: 1;
        /** @var Assign $assignNode */
        $assignNode = $nodeByTypeAndPosition->getParentNode();
        $isVariableAssigned = (bool) $this->betterNodeFinder->findFirst($assignNode->expr, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($nodeByTypeAndPosition) : bool {
            return $this->areNodesEqual($node, $nodeByTypeAndPosition->getVariableNode());
        });
        return !$isVariableAssigned;
    }
}
