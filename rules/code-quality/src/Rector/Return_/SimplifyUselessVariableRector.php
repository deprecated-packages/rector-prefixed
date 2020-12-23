<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Return_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see Based on https://github.com/slevomat/coding-standard/blob/master/SlevomatCodingStandard/Sniffs/Variables/UselessVariableSniff.php
 * @see \Rector\CodeQuality\Tests\Rector\Return_\SimplifyUselessVariableRector\SimplifyUselessVariableRectorTest
 */
final class SimplifyUselessVariableRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes useless variable assigns', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function () {
    $a = true;
    return $a;
};
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function () {
    return true;
};
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $previousNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$previousNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        /** @var AssignOp|Assign $previousNode */
        $previousNode = $previousNode->expr;
        $previousVariableNode = $previousNode->var;
        // has some comment
        if ($previousVariableNode->getComments() || $previousVariableNode->getDocComment()) {
            return null;
        }
        if ($previousNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            if ($this->isReturnWithVarAnnotation($node)) {
                return null;
            }
            $node->expr = $previousNode->expr;
        }
        if ($previousNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp) {
            $binaryClass = $this->assignAndBinaryMap->getAlternative($previousNode);
            if ($binaryClass === null) {
                return null;
            }
            $node->expr = new $binaryClass($previousNode->var, $previousNode->expr);
        }
        $this->removeNode($previousNode);
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : bool
    {
        if (!$return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return \true;
        }
        $variableNode = $return->expr;
        $previousExpression = $return->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($previousExpression === null || !$previousExpression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \true;
        }
        // is variable part of single assign
        $previousNode = $previousExpression->expr;
        if (!$previousNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp && !$previousNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        // is the same variable
        if (!$this->areNodesEqual($previousNode->var, $variableNode)) {
            return \true;
        }
        return $this->isPreviousExpressionVisuallySimilar($previousExpression, $previousNode);
    }
    private function isReturnWithVarAnnotation(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : bool
    {
        $phpDocInfo = $return->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return !$phpDocInfo->getVarType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
    }
    /**
     * @param AssignOp|Assign $previousNode
     */
    private function isPreviousExpressionVisuallySimilar(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $previousExpression, \_PhpScoper0a2ac50786fa\PhpParser\Node $previousNode) : bool
    {
        $prePreviousExpression = $previousExpression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if (!$prePreviousExpression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        if (!$prePreviousExpression->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp) {
            return \false;
        }
        return $this->areNodesEqual($prePreviousExpression->expr->var, $previousNode->var);
    }
}
