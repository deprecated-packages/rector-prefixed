<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Ternary\TernaryConditionVariableAssignmentRector\TernaryConditionVariableAssignmentRectorTest
 */
final class TernaryConditionVariableAssignmentRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Assign outcome of ternary condition to variable, where applicable', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function ternary($value)
{
    $value ? $a = 1 : $a = 0;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function ternary($value)
{
    $a = $value ? 1 : 0;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $nodeIf = $node->if;
        $nodeElse = $node->else;
        if (!$nodeIf instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign || !$nodeElse instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $nodeIfVar = $nodeIf->var;
        $nodeElseVar = $nodeElse->var;
        if (!$nodeIfVar instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable || !$nodeElseVar instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return null;
        }
        if ($nodeIfVar->name !== $nodeElseVar->name) {
            return null;
        }
        $previousNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($previousNode !== null) {
            return null;
        }
        $node->if = $nodeIf->expr;
        $node->else = $nodeElse->expr;
        $variable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($nodeIfVar->name);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($variable, $node);
    }
}
