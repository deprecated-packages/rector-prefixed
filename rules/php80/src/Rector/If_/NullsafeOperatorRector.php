<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/nullsafe_operator
 * @see \Rector\Php80\Tests\Rector\If_\NullsafeOperatorRector\NullsafeOperatorRectorTest
 */
final class NullsafeOperatorRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\NullsafeManipulator $nullsafeManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->nullsafeManipulator = $nullsafeManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change if null check with nullsafe operator ?-> with full short circuiting', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $processNullSafeOperator = $this->processNullSafeOperatorIdentical($node);
        if ($processNullSafeOperator !== null) {
            /** @var Expression $prevNode */
            $prevNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
            $this->removeNode($prevNode);
            return $processNullSafeOperator;
        }
        return $this->processNullSafeOperatorNotIdentical($node);
    }
    private function processNullSafeOperatorIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, bool $isStartIf = \true) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $comparedNode = $this->ifManipulator->matchIfValueReturnValue($if);
        if ($comparedNode === null) {
            return null;
        }
        $prevNode = $if->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        $nextNode = $if->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($prevNode === null) {
            return null;
        }
        if ($nextNode === null) {
            return null;
        }
        if (!$prevNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevNode->expr)) {
            return null;
        }
        $prevExpr = $prevNode->expr;
        if (!$prevExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->processAssign($prevExpr, $prevNode, $nextNode, $isStartIf);
    }
    private function processNullSafeOperatorNotIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
        $expression = $assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var Node|null $nextNode */
        $nextNode = $expression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
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
        if (!$nextNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($assign->var, $nullSafe);
        }
        return $this->processNullSafeOperatorNotIdentical($nextNode, $nullSafe);
    }
    private function processAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $prevExpression, \_PhpScoper0a2ac50786fa\PhpParser\Node $nextNode, bool $isStartIf) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($assign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign && \property_exists($assign->expr, self::NAME) && \property_exists($nextNode, 'expr') && \property_exists($nextNode->expr, self::NAME)) {
            return $this->processAssignInCurrentNode($assign, $prevExpression, $nextNode, $isStartIf);
        }
        return $this->processAssignMayInNextNode($nextNode);
    }
    private function processIfMayInNextNode(?\_PhpScoper0a2ac50786fa\PhpParser\Node $nextNode = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($nextNode === null) {
            return null;
        }
        $nextOfNextNode = $nextNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        while ($nextOfNextNode) {
            if ($nextOfNextNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
                /** @var If_ $beforeIf */
                $beforeIf = $nextOfNextNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                $nullSafe = $this->processNullSafeOperatorNotIdentical($nextOfNextNode);
                if (!$nullSafe instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall && !$nullSafe instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
                    return $beforeIf;
                }
                $beforeIf->stmts[\count((array) $beforeIf->stmts) - 1] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($nullSafe);
                return $beforeIf;
            }
            $nextOfNextNode = $nextOfNextNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        }
        return null;
    }
    private function processAssignInCurrentNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression, \_PhpScoper0a2ac50786fa\PhpParser\Node $nextNode, bool $isStartIf) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $assignNullSafe = $isStartIf ? $assign->expr : $this->nullsafeManipulator->processNullSafeExpr($assign->expr);
        $nullSafe = $this->nullsafeManipulator->processNullSafeExprResult($assignNullSafe, $nextNode->expr->name);
        $prevAssign = $expression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevAssign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            $nullSafe = $this->getNullSafeOnPrevAssignIsIf($prevAssign, $nextNode, $nullSafe);
        }
        $this->removeNode($nextNode);
        if ($nextNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            $nextNode->expr = $nullSafe;
            return $nextNode;
        }
        return $nullSafe;
    }
    private function processAssignMayInNextNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $nextNode) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$nextNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression || !$nextNode->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $mayNextIf = $nextNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$mayNextIf instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return null;
        }
        if ($this->ifManipulator->isIfCondUsingAssignIdenticalVariable($mayNextIf, $nextNode->expr)) {
            return $this->processNullSafeOperatorIdentical($mayNextIf, \false);
        }
        return null;
    }
    private function getNullSafeOnPrevAssignIsIf(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, \_PhpScoper0a2ac50786fa\PhpParser\Node $nextNode, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $prevIf = $if->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($prevIf instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $prevIf->expr)) {
            $start = $prevIf;
            while ($prevIf instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                $expr = $this->nullsafeManipulator->processNullSafeExpr($prevIf->expr->expr);
                /** @var If_ $prevIf */
                $prevIf = $prevIf->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                $prevIf = $prevIf->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                if (!$prevIf instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                    $start = $this->getStartNode($prevIf);
                    break;
                }
            }
            if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall && !$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch) {
                return $expr;
            }
            /** @var Expr $expr */
            $expr = $expr->var->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            $expr = $this->getNullSafeAfterStartUntilBeforeEnd($start, $expr);
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $nextNode->expr->name);
        }
        return $expr;
    }
    private function getStartNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var If_ $start */
        $start = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        $start = $start->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var If_ $start */
        $start = $start->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Expression $start */
        return $start->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    private function getNullSafeAfterStartUntilBeforeEnd(?\_PhpScoper0a2ac50786fa\PhpParser\Node $node, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        while ($node) {
            $expr = $this->nullsafeManipulator->processNullSafeExprResult($expr, $node->expr->expr->name);
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            while ($node) {
                /** @var If_ $if */
                $if = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
                if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression && $this->ifManipulator->isIfCondUsingAssignIdenticalVariable($if, $node->expr)) {
                    break;
                }
                $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
            }
        }
        return $expr;
    }
}
