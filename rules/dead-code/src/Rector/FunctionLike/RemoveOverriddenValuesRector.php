<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\FunctionLike;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\Rector\Core\Context\ContextAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\DeadCode\FlowControl\VariableUseFinder;
use _PhpScoper0a2ac50786fa\Rector\DeadCode\NodeCollector\NodeByTypeAndPositionCollector;
use _PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveOverriddenValuesRector\RemoveOverriddenValuesRectorTest
 */
final class RemoveOverriddenValuesRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Context\ContextAnalyzer $contextAnalyzer, \_PhpScoper0a2ac50786fa\Rector\DeadCode\NodeCollector\NodeByTypeAndPositionCollector $nodeByTypeAndPositionCollector, \_PhpScoper0a2ac50786fa\Rector\DeadCode\FlowControl\VariableUseFinder $variableUseFinder)
    {
        $this->contextAnalyzer = $contextAnalyzer;
        $this->nodeByTypeAndPositionCollector = $nodeByTypeAndPositionCollector;
        $this->variableUseFinder = $variableUseFinder;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove initial assigns of overridden values', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike::class];
    }
    /**
     * @param FunctionLike $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
    private function resolveAssignedVariables(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : array
    {
        return $this->betterNodeFinder->find($functionLike, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            // skin in if
            if ($this->contextAnalyzer->isInIf($node)) {
                return \false;
            }
            // is variable on the left
            /** @var Assign $assignNode */
            $assignNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
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
    private function isAssignNodeUsed(?\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse $previousNode, \_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse $nodeByTypeAndPosition) : bool
    {
        // this node was just used, skip to next one
        if ($previousNode === null) {
            return \false;
        }
        if (!$previousNode->isType(\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
            return \false;
        }
        return $nodeByTypeAndPosition->isType(\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_USE);
    }
    private function shouldRemoveAssignNode(?\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse $previousNode, \_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse $nodeByTypeAndPosition) : bool
    {
        if ($previousNode === null) {
            return \false;
        }
        if (!$previousNode->isType(\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
            return \false;
        }
        if (!$nodeByTypeAndPosition->isType(\_PhpScoper0a2ac50786fa\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN)) {
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
        $isVariableAssigned = (bool) $this->betterNodeFinder->findFirst($assignNode->expr, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($nodeByTypeAndPosition) : bool {
            return $this->areNodesEqual($node, $nodeByTypeAndPosition->getVariableNode());
        });
        return !$isVariableAssigned;
    }
}
