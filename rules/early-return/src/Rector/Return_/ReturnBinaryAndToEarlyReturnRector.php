<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\EarlyReturn\Rector\Return_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Return_\ReturnBinaryAndToEarlyReturnRector\ReturnBinaryAndToEarlyReturnRectorTest
 */
final class ReturnBinaryAndToEarlyReturnRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Single return of && && to early returns', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
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
        $this->addNodeBeforeNode(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_($lastReturnExpr), $node);
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function createMultipleIfsNegation(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        while ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $ifNegations = \array_merge($ifNegations, $this->collectLeftBooleanAndToIfs($expr, $return, $ifNegations));
            $ifNegations[] = $this->createIfNegation($expr->right);
            $expr = $expr->right;
        }
        return $ifNegations + [$this->createIfNegation($expr)];
    }
    private function getLastReturnExpr(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_) {
            return $expr;
        }
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
            return $expr;
        }
        $scope = $expr->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope) {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_($expr);
        }
        $type = $scope->getType($expr);
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType) {
            return $expr;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    /**
     * @param If_[] $ifNegations
     * @return If_[]
     */
    private function collectLeftBooleanAndToIfs(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd $booleanAnd, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_ $return, array $ifNegations) : array
    {
        $left = $booleanAnd->left;
        if (!$left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            return [$this->createIfNegation($left)];
        }
        return $this->createMultipleIfsNegation($left, $return, $ifNegations);
    }
    private function createIfNegation(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_
    {
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical) {
            $expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr->left, $expr->right);
        } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            $expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, $expr->right);
        } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
            $expr = $expr->expr;
        } else {
            $expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot($expr);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_($expr, ['stmts' => [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_($this->createFalse())]]);
    }
}
