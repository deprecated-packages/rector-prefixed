<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\If_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Comment\CommentsMerger;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\SimplifyIfReturnBoolRector\SimplifyIfReturnBoolRectorTest
 */
final class SimplifyIfReturnBoolRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var StaticTypeAnalyzer
     */
    private $staticTypeAnalyzer;
    /**
     * @var CommentsMerger
     */
    private $commentsMerger;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer $staticTypeAnalyzer)
    {
        $this->staticTypeAnalyzer = $staticTypeAnalyzer;
        $this->commentsMerger = $commentsMerger;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Shortens if return false/true to direct return', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
if (strpos($docToken->getContent(), "\n") === false) {
    return true;
}

return false;
CODE_SAMPLE
, 'return strpos($docToken->getContent(), "\\n") === false;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Return_ $ifInnerNode */
        $ifInnerNode = $node->stmts[0];
        /** @var Return_ $nextNode */
        $nextNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Node $innerIfInnerNode */
        $innerIfInnerNode = $ifInnerNode->expr;
        if ($this->isTrue($innerIfInnerNode)) {
            $newReturnNode = $this->processReturnTrue($node, $nextNode);
        } elseif ($this->isFalse($innerIfInnerNode)) {
            $newReturnNode = $this->processReturnFalse($node, $nextNode);
        } else {
            return null;
        }
        if ($newReturnNode === null) {
            return null;
        }
        $this->commentsMerger->keepComments($newReturnNode, [$node, $ifInnerNode, $nextNode, $newReturnNode]);
        $this->removeNode($nextNode);
        return $newReturnNode;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->elseifs !== []) {
            return \true;
        }
        if ($this->isElseSeparatedThenIf($if)) {
            return \true;
        }
        if (!$this->isIfWithSingleReturnExpr($if)) {
            return \true;
        }
        /** @var Return_ $ifInnerNode */
        $ifInnerNode = $if->stmts[0];
        /** @var Expr $returnedExpr */
        $returnedExpr = $ifInnerNode->expr;
        if (!$this->isBool($returnedExpr)) {
            return \true;
        }
        $nextNode = $if->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ || $nextNode->expr === null) {
            return \true;
        }
        // negate + negate → skip for now
        if ($this->isFalse($returnedExpr) && \_PhpScopere8e811afab72\Nette\Utils\Strings::contains($this->print($if->cond), '!=')) {
            return \true;
        }
        return !$this->isBool($nextNode->expr);
    }
    private function processReturnTrue(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $nextReturnNode) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        if ($if->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot && $nextReturnNode->expr !== null && $this->isTrue($nextReturnNode->expr)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond->expr));
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond));
    }
    private function processReturnFalse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $nextReturnNode) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        if ($if->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($if->cond->left, $if->cond->right)));
        }
        if ($nextReturnNode->expr === null) {
            return null;
        }
        if (!$this->isTrue($nextReturnNode->expr)) {
            return null;
        }
        if ($if->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond->expr));
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($if->cond)));
    }
    /**
     * Matches: "else if"
     */
    private function isElseSeparatedThenIf(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else === null) {
            return \false;
        }
        if (\count((array) $if->else->stmts) !== 1) {
            return \false;
        }
        $onlyStmt = $if->else->stmts[0];
        return $onlyStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
    }
    private function isIfWithSingleReturnExpr(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if (\count((array) $if->stmts) !== 1) {
            return \false;
        }
        if ($if->elseifs !== []) {
            return \false;
        }
        $ifInnerNode = $if->stmts[0];
        if (!$ifInnerNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        // return must have value
        return $ifInnerNode->expr !== null;
    }
    private function boolCastOrNullCompareIfNeeded(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isNullableType($expr)) {
            $exprStaticType = $this->getStaticType($expr);
            // if we remove null type, still has to be trueable
            if ($exprStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                $unionTypeWithoutNullType = $this->typeUnwrapper->removeNullTypeFromUnionType($exprStaticType);
                if ($this->staticTypeAnalyzer->isAlwaysTruableType($unionTypeWithoutNullType)) {
                    return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->createNull());
                }
            } elseif ($this->staticTypeAnalyzer->isAlwaysTruableType($exprStaticType)) {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->createNull());
            }
        }
        if (!$this->isBoolCastNeeded($expr)) {
            return $expr;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    private function isBoolCastNeeded(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if ($this->isStaticType($expr, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
            return \false;
        }
        return !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
    }
}
