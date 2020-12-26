<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\If_;

use RectorPrefix2020DecSat\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\Comment\CommentsMerger;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\SimplifyIfReturnBoolRector\SimplifyIfReturnBoolRectorTest
 */
final class SimplifyIfReturnBoolRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var StaticTypeAnalyzer
     */
    private $staticTypeAnalyzer;
    /**
     * @var CommentsMerger
     */
    private $commentsMerger;
    public function __construct(\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger, \Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer $staticTypeAnalyzer)
    {
        $this->staticTypeAnalyzer = $staticTypeAnalyzer;
        $this->commentsMerger = $commentsMerger;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Shortens if return false/true to direct return', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Return_ $ifInnerNode */
        $ifInnerNode = $node->stmts[0];
        /** @var Return_ $nextNode */
        $nextNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
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
    private function shouldSkip(\PhpParser\Node\Stmt\If_ $if) : bool
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
        $nextNode = $if->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        if ($nextNode->expr === null) {
            return \true;
        }
        // negate + negate → skip for now
        if ($this->isFalse($returnedExpr) && \RectorPrefix2020DecSat\Nette\Utils\Strings::contains($this->print($if->cond), '!=')) {
            return \true;
        }
        return !$this->isBool($nextNode->expr);
    }
    private function processReturnTrue(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Stmt\Return_ $nextReturnNode) : \PhpParser\Node\Stmt\Return_
    {
        if ($if->cond instanceof \PhpParser\Node\Expr\BooleanNot && $nextReturnNode->expr !== null && $this->isTrue($nextReturnNode->expr)) {
            return new \PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond->expr));
        }
        return new \PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond));
    }
    private function processReturnFalse(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Stmt\Return_ $nextReturnNode) : ?\PhpParser\Node\Stmt\Return_
    {
        if ($if->cond instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return new \PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded(new \PhpParser\Node\Expr\BinaryOp\NotIdentical($if->cond->left, $if->cond->right)));
        }
        if ($nextReturnNode->expr === null) {
            return null;
        }
        if (!$this->isTrue($nextReturnNode->expr)) {
            return null;
        }
        if ($if->cond instanceof \PhpParser\Node\Expr\BooleanNot) {
            return new \PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded($if->cond->expr));
        }
        return new \PhpParser\Node\Stmt\Return_($this->boolCastOrNullCompareIfNeeded(new \PhpParser\Node\Expr\BooleanNot($if->cond)));
    }
    /**
     * Matches: "else if"
     */
    private function isElseSeparatedThenIf(\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else === null) {
            return \false;
        }
        if (\count($if->else->stmts) !== 1) {
            return \false;
        }
        $onlyStmt = $if->else->stmts[0];
        return $onlyStmt instanceof \PhpParser\Node\Stmt\If_;
    }
    private function isIfWithSingleReturnExpr(\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if (\count($if->stmts) !== 1) {
            return \false;
        }
        if ($if->elseifs !== []) {
            return \false;
        }
        $ifInnerNode = $if->stmts[0];
        if (!$ifInnerNode instanceof \PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        // return must have value
        return $ifInnerNode->expr !== null;
    }
    private function boolCastOrNullCompareIfNeeded(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr
    {
        if ($this->isNullableType($expr)) {
            $exprStaticType = $this->getStaticType($expr);
            // if we remove null type, still has to be trueable
            if ($exprStaticType instanceof \PHPStan\Type\UnionType) {
                $unionTypeWithoutNullType = $this->typeUnwrapper->removeNullTypeFromUnionType($exprStaticType);
                if ($this->staticTypeAnalyzer->isAlwaysTruableType($unionTypeWithoutNullType)) {
                    return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->createNull());
                }
            } elseif ($this->staticTypeAnalyzer->isAlwaysTruableType($exprStaticType)) {
                return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->createNull());
            }
        }
        if (!$this->isBoolCastNeeded($expr)) {
            return $expr;
        }
        return new \PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    private function isBoolCastNeeded(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if ($this->isStaticType($expr, \PHPStan\Type\BooleanType::class)) {
            return \false;
        }
        return !$expr instanceof \PhpParser\Node\Expr\BinaryOp;
    }
}
