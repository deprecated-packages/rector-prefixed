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
use Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/nullsafe_operator
 * @see \Rector\Php80\Tests\Rector\If_\NullsafeOperatorRector\NullsafeOperatorRectorTest
 */
final class NullsafeOperatorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const NAME = 'name';
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var NullsafeManipulator
     */
    private $nullsafeManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator $nullsafeManipulator)
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
    private function processNullSafeOperatorIdentical(\PhpParser\Node\Stmt\If_ $if, bool $isStartIf = \true) : ?\PhpParser\Node
    {
        $comparedNode = $this->ifManipulator->matchIfValueReturnValue($if);
        if ($comparedNode === null) {
            return null;
        }
        $prevNode = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        $nextNode = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($prevNode === null || $nextNode === null) {
            return null;
        }
        if (!$prevNode instanceof \PhpParser\Node\Stmt\Expression || !$this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevNode->expr)) {
            return null;
        }
        /** @var Assign $assign */
        $assign = $prevNode->expr;
        return $this->processAssign($assign, $prevNode, $nextNode, $isStartIf);
    }
    private function processNullSafeOperatorNotIdentical(\PhpParser\Node\Stmt\If_ $if, ?\PhpParser\Node\Expr $expr = null) : ?\PhpParser\Node
    {
        $assign = $this->ifManipulator->matchIfNotNullNextAssignment($if);
        if ($assign === null) {
            return null;
        }
        $assignExpr = $assign->expr;
        if ($this->ifManipulator->isIfCondUsingAssignNotIdenticalVariable($if, $assignExpr)) {
            return null;
        }
        /** @var Expression $expression */
        $expression = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var Node|null $nextNode */
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
    private function processAssign(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node $prevNode, \PhpParser\Node $nextNode, bool $isStartIf) : ?\PhpParser\Node
    {
        if ($assign instanceof \PhpParser\Node\Expr\Assign && \property_exists($assign->expr, self::NAME) && \property_exists($nextNode, 'expr') && \property_exists($nextNode->expr, self::NAME)) {
            return $this->processAssignInCurrentNode($assign, $prevNode, $nextNode, $isStartIf);
        }
        return $this->processAssignMayInNextNode($nextNode);
    }
    private function processIfMayInNextNode(?\PhpParser\Node $nextNode = null) : ?\PhpParser\Node
    {
        if ($nextNode === null) {
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
    private function processAssignInCurrentNode(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node $prevNode, \PhpParser\Node $nextNode, bool $isStartIf) : ?\PhpParser\Node
    {
        $assignNullSafe = !$isStartIf ? $this->nullsafeManipulator->processNullSafeExpr($assign->expr) : $assign->expr;
        $nullSafe = $this->nullsafeManipulator->processNullSafeExprResult($assignNullSafe, $nextNode->expr->name);
        $prevAssign = $prevNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
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
    private function processAssignMayInNextNode(\PhpParser\Node $nextNode) : ?\PhpParser\Node
    {
        if (!$nextNode instanceof \PhpParser\Node\Stmt\Expression || !$nextNode->expr instanceof \PhpParser\Node\Expr\Assign) {
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
    private function getNullSafeOnPrevAssignIsIf(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node $nextNode, ?\PhpParser\Node\Expr $expr) : ?\PhpParser\Node\Expr
    {
        $prevIf = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevIf instanceof \PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevIf->expr)) {
            $start = $prevIf;
            while ($prevIf instanceof \PhpParser\Node\Stmt\Expression) {
                $expr = $this->nullsafeManipulator->processNullSafeExpr($prevIf->expr->expr);
                /** @var If_ $prevIf */
                $prevIf = $prevIf->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                /** @var Expression|Identifier $prevIf */
                $prevIf = $prevIf->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                if (!$prevIf instanceof \PhpParser\Node\Stmt\Expression) {
                    $start = $this->getStartNode($prevIf);
                    break;
                }
            }
            if (!$expr instanceof \PhpParser\Node\Expr\NullsafeMethodCall && !$expr instanceof \PhpParser\Node\Expr\NullsafePropertyFetch) {
                return $expr;
            }
            /** @var Expr $expr */
            $expr = $expr->var->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            $expr = $this->getNullSafeAfterStartUntilBeforeEnd($start, $expr);
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $nextNode->expr->name);
        }
        return $expr;
    }
    private function getStartNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var If_ $start */
        $start = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        $start = $start->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var If_ $start */
        $start = $start->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        return $start->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    private function getNullSafeAfterStartUntilBeforeEnd(?\PhpParser\Node $node, ?\PhpParser\Node\Expr $expr) : ?\PhpParser\Node\Expr
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
