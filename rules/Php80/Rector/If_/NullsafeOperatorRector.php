<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\NullsafePropertyFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\NodeManipulator\IfManipulator;
use Rector\Core\NodeManipulator\NullsafeManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://wiki.php.net/rfc/nullsafe_operator
 * @see \Rector\Tests\Php80\Rector\If_\NullsafeOperatorRector\NullsafeOperatorRectorTest
 */
final class NullsafeOperatorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    const NAME = 'name';
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var NullsafeManipulator
     */
    private $nullsafeManipulator;
    public function __construct(\Rector\Core\NodeManipulator\IfManipulator $ifManipulator, \Rector\Core\NodeManipulator\NullsafeManipulator $nullsafeManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->nullsafeManipulator = $nullsafeManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change if null check with nullsafe operator ?-> with full short circuiting', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($someObject)
    {
        $someObject2 = $someObject->mayFail1();
        if ($someObject2 === null) {
            return null;
        }

        return $someObject2->mayFail2();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($someObject)
    {
        return $someObject->mayFail1()?->mayFail2();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        $processNullSafeOperator = $this->processNullSafeOperatorIdentical($node);
        if ($processNullSafeOperator !== null) {
            /** @var Expression $prevNode */
            $prevNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
            $this->removeNode($prevNode);
            return $processNullSafeOperator;
        }
        return $this->processNullSafeOperatorNotIdentical($node);
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function processNullSafeOperatorIdentical(\PhpParser\Node\Stmt\If_ $if, bool $isStartIf = \true)
    {
        $comparedNode = $this->ifManipulator->matchIfValueReturnValue($if);
        if (!$comparedNode instanceof \PhpParser\Node\Expr) {
            return null;
        }
        $prevNode = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        $nextNode = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$prevNode instanceof \PhpParser\Node) {
            return null;
        }
        if (!$nextNode instanceof \PhpParser\Node) {
            return null;
        }
        if (!$prevNode instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevNode->expr)) {
            return null;
        }
        $prevExpr = $prevNode->expr;
        if (!$prevExpr instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->processAssign($prevExpr, $prevNode, $nextNode, $isStartIf);
    }
    /**
     * @param \PhpParser\Node\Expr|null $expr
     * @return \PhpParser\Node|null
     */
    private function processNullSafeOperatorNotIdentical(\PhpParser\Node\Stmt\If_ $if, $expr = null)
    {
        $assign = $this->ifManipulator->matchIfNotNullNextAssignment($if);
        if (!$assign instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        $assignExpr = $assign->expr;
        if ($this->ifManipulator->isIfCondUsingAssignNotIdenticalVariable($if, $assignExpr)) {
            return null;
        }
        /** @var Expression $expression */
        $expression = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $nextNode = $expression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var NullsafeMethodCall|NullsafePropertyFetch $nullSafe */
        $nullSafe = $this->nullsafeManipulator->processNullSafeExpr($assignExpr);
        if ($expr !== null) {
            /** @var Identifier $nullSafeIdentifier */
            $nullSafeIdentifier = $nullSafe->name;
            /** @var NullsafeMethodCall|NullsafePropertyFetch $nullSafe */
            $nullSafe = $this->nullsafeManipulator->processNullSafeExprResult($expr, $nullSafeIdentifier);
        }
        $nextOfNextNode = $this->processIfMayInNextNode($nextNode);
        if ($nextOfNextNode !== null) {
            return $nextOfNextNode;
        }
        if (!$nextNode instanceof \PhpParser\Node\Stmt\If_) {
            return new \PhpParser\Node\Expr\Assign($assign->var, $nullSafe);
        }
        return $this->processNullSafeOperatorNotIdentical($nextNode, $nullSafe);
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function processAssign(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node\Stmt\Expression $prevExpression, \PhpParser\Node $nextNode, bool $isStartIf)
    {
        if ($assign instanceof \PhpParser\Node\Expr\Assign && \property_exists($assign->expr, self::NAME) && \property_exists($nextNode, 'expr') && \property_exists($nextNode->expr, self::NAME)) {
            return $this->processAssignInCurrentNode($assign, $prevExpression, $nextNode, $isStartIf);
        }
        return $this->processAssignMayInNextNode($nextNode);
    }
    /**
     * @param \PhpParser\Node|null $nextNode
     * @return \PhpParser\Node|null
     */
    private function processIfMayInNextNode($nextNode = null)
    {
        if (!$nextNode instanceof \PhpParser\Node) {
            return null;
        }
        $nextOfNextNode = $nextNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        while ($nextOfNextNode) {
            if ($nextOfNextNode instanceof \PhpParser\Node\Stmt\If_) {
                /** @var If_ $beforeIf */
                $beforeIf = $nextOfNextNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                $nullSafe = $this->processNullSafeOperatorNotIdentical($nextOfNextNode);
                if (!$nullSafe instanceof \PhpParser\Node\Expr\NullsafeMethodCall && !$nullSafe instanceof \PhpParser\Node\Expr\PropertyFetch) {
                    return $beforeIf;
                }
                $beforeIf->stmts[\count($beforeIf->stmts) - 1] = new \PhpParser\Node\Stmt\Expression($nullSafe);
                return $beforeIf;
            }
            $nextOfNextNode = $nextOfNextNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return null;
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function processAssignInCurrentNode(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node\Stmt\Expression $expression, \PhpParser\Node $nextNode, bool $isStartIf)
    {
        $assignNullSafe = $isStartIf ? $assign->expr : $this->nullsafeManipulator->processNullSafeExpr($assign->expr);
        $nullSafe = $this->nullsafeManipulator->processNullSafeExprResult($assignNullSafe, $nextNode->expr->name);
        $prevAssign = $expression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevAssign instanceof \PhpParser\Node\Stmt\If_) {
            $nullSafe = $this->getNullSafeOnPrevAssignIsIf($prevAssign, $nextNode, $nullSafe);
        }
        $this->removeNode($nextNode);
        if ($nextNode instanceof \PhpParser\Node\Stmt\Return_) {
            $nextNode->expr = $nullSafe;
            return $nextNode;
        }
        return $nullSafe;
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function processAssignMayInNextNode(\PhpParser\Node $nextNode)
    {
        if (!$nextNode instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$nextNode->expr instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        $mayNextIf = $nextNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$mayNextIf instanceof \PhpParser\Node\Stmt\If_) {
            return null;
        }
        if ($this->ifManipulator->isIfCondUsingAssignIdenticalVariable($mayNextIf, $nextNode->expr)) {
            return $this->processNullSafeOperatorIdentical($mayNextIf, \false);
        }
        return null;
    }
    /**
     * @param \PhpParser\Node\Expr|null $expr
     * @return \PhpParser\Node\Expr|null
     */
    private function getNullSafeOnPrevAssignIsIf(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node $nextNode, $expr)
    {
        $prevIf = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$prevIf instanceof \PhpParser\Node\Stmt\Expression) {
            return $expr;
        }
        if (!$this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevIf->expr)) {
            return $expr;
        }
        $start = $prevIf;
        while ($prevIf instanceof \PhpParser\Node\Stmt\Expression) {
            $expressionNode = $prevIf->expr;
            if (!$expressionNode instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            $expr = $this->nullsafeManipulator->processNullSafeExpr($expressionNode->expr);
            /** @var Node $prevPrevIf */
            $prevPrevIf = $prevIf->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
            /** @var Node $prevPrevPrevIf */
            $prevPrevPrevIf = $prevPrevIf->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
            if (!$prevPrevPrevIf instanceof \PhpParser\Node\Stmt\Expression && $prevPrevPrevIf !== null) {
                $start = $this->getPreviousIf($prevPrevPrevIf);
                break;
            }
            $prevIf = $prevPrevPrevIf;
        }
        if (!$expr instanceof \PhpParser\Node\Expr\NullsafeMethodCall && !$expr instanceof \PhpParser\Node\Expr\NullsafePropertyFetch) {
            return $expr;
        }
        /** @var Expr $expr */
        $expr = $expr->var->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $expr = $this->getNullSafeAfterStartUntilBeforeEnd($start, $expr);
        return $this->nullsafeManipulator->processNullSafeExprResult($expr, $nextNode->expr->name);
    }
    /**
     * @return \PhpParser\Node|null
     */
    private function getPreviousIf(\PhpParser\Node $node)
    {
        /** @var If_ $if */
        $if = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $expression */
        $expression = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $nextExpression */
        $nextExpression = $expression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        return $nextExpression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    /**
     * @param \PhpParser\Node|null $node
     * @param \PhpParser\Node\Expr|null $expr
     * @return \PhpParser\Node\Expr|null
     */
    private function getNullSafeAfterStartUntilBeforeEnd($node, $expr)
    {
        while ($node) {
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $node->expr->expr->name);
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            while ($node) {
                /** @var If_ $if */
                $if = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
                if ($node instanceof \PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $node->expr)) {
                    break;
                }
                $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            }
        }
        return $expr;
    }
}
