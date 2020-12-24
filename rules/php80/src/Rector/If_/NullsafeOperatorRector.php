<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Rector\If_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/nullsafe_operator
 * @see \Rector\Php80\Tests\Rector\If_\NullsafeOperatorRector\NullsafeOperatorRectorTest
 */
final class NullsafeOperatorRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator $nullsafeManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->nullsafeManipulator = $nullsafeManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change if null check with nullsafe operator ?-> with full short circuiting', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $processNullSafeOperator = $this->processNullSafeOperatorIdentical($node);
        if ($processNullSafeOperator !== null) {
            /** @var Expression $prevNode */
            $prevNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
            $this->removeNode($prevNode);
            return $processNullSafeOperator;
        }
        return $this->processNullSafeOperatorNotIdentical($node);
    }
    private function processNullSafeOperatorIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, bool $isStartIf = \true) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $comparedNode = $this->ifManipulator->matchIfValueReturnValue($if);
        if ($comparedNode === null) {
            return null;
        }
        $prevNode = $if->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        $nextNode = $if->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($prevNode === null) {
            return null;
        }
        if ($nextNode === null) {
            return null;
        }
        if (!$prevNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevNode->expr)) {
            return null;
        }
        $prevExpr = $prevNode->expr;
        if (!$prevExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->processAssign($prevExpr, $prevNode, $nextNode, $isStartIf);
    }
    private function processNullSafeOperatorNotIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
        $expression = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var Node|null $nextNode */
        $nextNode = $expression->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
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
        if (!$nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($assign->var, $nullSafe);
        }
        return $this->processNullSafeOperatorNotIdentical($nextNode, $nullSafe);
    }
    private function processAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $prevExpression, \_PhpScoperb75b35f52b74\PhpParser\Node $nextNode, bool $isStartIf) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($assign instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && \property_exists($assign->expr, self::NAME) && \property_exists($nextNode, 'expr') && \property_exists($nextNode->expr, self::NAME)) {
            return $this->processAssignInCurrentNode($assign, $prevExpression, $nextNode, $isStartIf);
        }
        return $this->processAssignMayInNextNode($nextNode);
    }
    private function processIfMayInNextNode(?\_PhpScoperb75b35f52b74\PhpParser\Node $nextNode = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($nextNode === null) {
            return null;
        }
        $nextOfNextNode = $nextNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        while ($nextOfNextNode) {
            if ($nextOfNextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
                /** @var If_ $beforeIf */
                $beforeIf = $nextOfNextNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                $nullSafe = $this->processNullSafeOperatorNotIdentical($nextOfNextNode);
                if (!$nullSafe instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall && !$nullSafe instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                    return $beforeIf;
                }
                $beforeIf->stmts[\count((array) $beforeIf->stmts) - 1] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($nullSafe);
                return $beforeIf;
            }
            $nextOfNextNode = $nextOfNextNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return null;
    }
    private function processAssignInCurrentNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $expression, \_PhpScoperb75b35f52b74\PhpParser\Node $nextNode, bool $isStartIf) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $assignNullSafe = $isStartIf ? $assign->expr : $this->nullsafeManipulator->processNullSafeExpr($assign->expr);
        $nullSafe = $this->nullsafeManipulator->processNullSafeExprResult($assignNullSafe, $nextNode->expr->name);
        $prevAssign = $expression->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevAssign instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            $nullSafe = $this->getNullSafeOnPrevAssignIsIf($prevAssign, $nextNode, $nullSafe);
        }
        $this->removeNode($nextNode);
        if ($nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            $nextNode->expr = $nullSafe;
            return $nextNode;
        }
        return $nullSafe;
    }
    private function processAssignMayInNextNode(\_PhpScoperb75b35f52b74\PhpParser\Node $nextNode) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression || !$nextNode->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $mayNextIf = $nextNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$mayNextIf instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            return null;
        }
        if ($this->ifManipulator->isIfCondUsingAssignIdenticalVariable($mayNextIf, $nextNode->expr)) {
            return $this->processNullSafeOperatorIdentical($mayNextIf, \false);
        }
        return null;
    }
    private function getNullSafeOnPrevAssignIsIf(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, \_PhpScoperb75b35f52b74\PhpParser\Node $nextNode, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $prevIf = $if->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevIf instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevIf->expr)) {
            $start = $prevIf;
            while ($prevIf instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                $expr = $this->nullsafeManipulator->processNullSafeExpr($prevIf->expr->expr);
                /** @var If_ $prevIf */
                $prevIf = $prevIf->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                $prevIf = $prevIf->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                if (!$prevIf instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                    $start = $this->getStartNode($prevIf);
                    break;
                }
            }
            if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch) {
                return $expr;
            }
            /** @var Expr $expr */
            $expr = $expr->var->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            $expr = $this->getNullSafeAfterStartUntilBeforeEnd($start, $expr);
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $nextNode->expr->name);
        }
        return $expr;
    }
    private function getStartNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var If_ $start */
        $start = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        $start = $start->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var If_ $start */
        $start = $start->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        return $start->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    private function getNullSafeAfterStartUntilBeforeEnd(?\_PhpScoperb75b35f52b74\PhpParser\Node $node, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        while ($node) {
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $node->expr->expr->name);
            $node = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            while ($node) {
                /** @var If_ $if */
                $if = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
                if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $node->expr)) {
                    break;
                }
                $node = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            }
        }
        return $expr;
    }
}
