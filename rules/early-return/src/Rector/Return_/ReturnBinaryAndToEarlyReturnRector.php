<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\EarlyReturn\Rector\Return_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Return_\ReturnBinaryAndToEarlyReturnRector\ReturnBinaryAndToEarlyReturnRectorTest
 */
final class ReturnBinaryAndToEarlyReturnRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Single return of && && to early returns', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function accept($something, $somethingelse)
    {
        return $something && $somethingelse;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function accept($something, $somethingelse)
    {
        if (!$something) {
            return false;
        }
        return (bool) $somethingelse;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return null;
        }
        $left = $node->expr->left;
        $ifNegations = $this->createMultipleIfsNegation($left, $node, []);
        foreach ($ifNegations as $key => $ifNegation) {
            if ($key === 0) {
                $this->mirrorComments($ifNegation, $node);
            }
            $this->addNodeBeforeNode($ifNegation, $node);
        }
        $lastReturnExpr = $this->getLastReturnExpr($node->expr->right);
        $this->addNodeBeforeNode(new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($lastReturnExpr), $node);
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function createMultipleIfsNegation(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        while ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $ifNegations = \array_merge($ifNegations, $this->collectLeftBooleanAndToIfs($expr, $return, $ifNegations));
            $ifNegations[] = $this->createIfNegation($expr->right);
            $expr = $expr->right;
        }
        return $ifNegations + [$this->createIfNegation($expr)];
    }
    private function getLastReturnExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_) {
            return $expr;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            return $expr;
        }
        $scope = $expr->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($expr);
        }
        $type = $scope->getType($expr);
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
            return $expr;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function collectLeftBooleanAndToIfs(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd $booleanAnd, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        $left = $booleanAnd->left;
        if (!$left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return [$this->createIfNegation($left)];
        }
        return $this->createMultipleIfsNegation($left, $return, $ifNegations);
    }
    private function createIfNegation(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            $expr = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr->left, $expr->right);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            $expr = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, $expr->right);
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            $expr = $expr->expr;
        } else {
            $expr = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($expr);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_($expr, ['stmts' => [new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($this->createFalse())]]);
    }
}
