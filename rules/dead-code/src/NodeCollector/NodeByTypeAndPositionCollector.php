<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeCollector;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\FlowOfControlLocator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class NodeByTypeAndPositionCollector
{
    /**
     * @var FlowOfControlLocator
     */
    private $flowOfControlLocator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNestingScope\FlowOfControlLocator $flowOfControlLocator, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->flowOfControlLocator = $flowOfControlLocator;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Variable[] $assignedVariables
     * @param Variable[] $assignedVariablesUse
     * @return VariableNodeUse[]
     */
    public function collectNodesByTypeAndPosition(array $assignedVariables, array $assignedVariablesUse, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $nodesByTypeAndPosition = [];
        foreach ($assignedVariables as $assignedVariable) {
            /** @var int $startTokenPos */
            $startTokenPos = $assignedVariable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::START_TOKEN_POSITION);
            // not in different scope, than previous one - e.g. if/while/else...
            // get nesting level to $classMethodNode
            /** @var Assign $assign */
            $assign = $assignedVariable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            $nestingHash = $this->flowOfControlLocator->resolveNestingHashFromFunctionLike($functionLike, $assign);
            /** @var string $variableName */
            $variableName = $this->nodeNameResolver->getName($assignedVariable);
            $nodesByTypeAndPosition[] = new \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse($startTokenPos, $variableName, \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_ASSIGN, $assignedVariable, $nestingHash);
        }
        foreach ($assignedVariablesUse as $assignedVariableUse) {
            /** @var int $startTokenPos */
            $startTokenPos = $assignedVariableUse->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::START_TOKEN_POSITION);
            /** @var string $variableName */
            $variableName = $this->nodeNameResolver->getName($assignedVariableUse);
            $nodesByTypeAndPosition[] = new \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse($startTokenPos, $variableName, \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse::TYPE_USE, $assignedVariableUse);
        }
        return $this->sortByStart($nodesByTypeAndPosition);
    }
    /**
     * @param VariableNodeUse[] $nodesByTypeAndPosition
     * @return VariableNodeUse[]
     */
    private function sortByStart(array $nodesByTypeAndPosition) : array
    {
        \usort($nodesByTypeAndPosition, function (\_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $firstVariableNodeUse, \_PhpScoperb75b35f52b74\Rector\DeadCode\ValueObject\VariableNodeUse $secondVariableNodeUse) : int {
            return $firstVariableNodeUse->getStartTokenPosition() <=> $secondVariableNodeUse->getStartTokenPosition();
        });
        return $nodesByTypeAndPosition;
    }
}
