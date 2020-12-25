<?php

declare (strict_types=1);
namespace Rector\Legacy\NodeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
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
    public function matchStaticPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr\StaticPropertyFetch
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 2) {
            return null;
        }
        $firstStmt = $stmts[0] ?? null;
        if (!$firstStmt instanceof \PhpParser\Node\Stmt\If_) {
            return null;
        }
        $staticPropertyFetch = $this->matchStaticPropertyFetchInIfCond($firstStmt->cond);
        if (\count((array) $firstStmt->stmts) !== 1) {
            return null;
        }
        if (!$firstStmt->stmts[0] instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $stmt = $firstStmt->stmts[0]->expr;
        // create self and assign to static property
        if (!$stmt instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$this->betterStandardPrinter->areNodesEqual($staticPropertyFetch, $stmt->var)) {
            return null;
        }
        if (!$stmt->expr instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        /** @var string $class */
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // the "self" class is created
        if (!$this->nodeTypeResolver->isObjectType($stmt->expr->class, $class)) {
            return null;
        }
        /** @var StaticPropertyFetch $staticPropertyFetch */
        return $staticPropertyFetch;
    }
    private function matchStaticPropertyFetchInIfCond(\PhpParser\Node\Expr $expr) : ?\PhpParser\Node\Expr\StaticPropertyFetch
    {
        // matching: "self::$static === null"
        if ($expr instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            if ($this->constFetchManipulator->isNull($expr->left) && $expr->right instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
                return $expr->right;
            }
            if ($this->constFetchManipulator->isNull($expr->right) && $expr->left instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
                return $expr->left;
            }
        }
        // matching: "! self::$static"
        if ($expr instanceof \PhpParser\Node\Expr\BooleanNot && $expr->expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return $expr->expr;
        }
        return null;
    }
}
