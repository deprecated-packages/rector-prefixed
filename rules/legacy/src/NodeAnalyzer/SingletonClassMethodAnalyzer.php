<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class SingletonClassMethodAnalyzer
{
    /**
     * @var ConstFetchManipulator
     */
    private $constFetchManipulator;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->constFetchManipulator = $constFetchManipulator;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * Match this code:
     * if (null === static::$instance) {
     *     static::$instance = new static();
     * }
     * return static::$instance;
     *
     * Matches "static::$instance" on success
     */
    public function matchStaticPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 2) {
            return null;
        }
        $firstStmt = $stmts[0] ?? null;
        if (!$firstStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
            return null;
        }
        $staticPropertyFetch = $this->matchStaticPropertyFetchInIfCond($firstStmt->cond);
        if (\count((array) $firstStmt->stmts) !== 1) {
            return null;
        }
        if (!$firstStmt->stmts[0] instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $stmt = $firstStmt->stmts[0]->expr;
        // create self and assign to static property
        if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$this->betterStandardPrinter->areNodesEqual($staticPropertyFetch, $stmt->var)) {
            return null;
        }
        if (!$stmt->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return null;
        }
        /** @var string $class */
        $class = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // the "self" class is created
        if (!$this->nodeTypeResolver->isObjectType($stmt->expr->class, $class)) {
            return null;
        }
        /** @var StaticPropertyFetch $staticPropertyFetch */
        return $staticPropertyFetch;
    }
    private function matchStaticPropertyFetchInIfCond(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch
    {
        // matching: "self::$static === null"
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            if ($this->constFetchManipulator->isNull($expr->left) && $expr->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
                return $expr->right;
            }
            if ($this->constFetchManipulator->isNull($expr->right) && $expr->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
                return $expr->left;
            }
        }
        // matching: "! self::$static"
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot && $expr->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return $expr->expr;
        }
        return null;
    }
}
