<?php

declare (strict_types=1);
namespace Rector\Defluent\ValueObject;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractRootExpr implements \Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var bool
     */
    protected $isFirstCallFactory = \false;
    /**
     * @var Expr
     */
    protected $rootExpr;
    /**
     * @var Expr
     */
    protected $assignExpr;
    public function createFirstAssign() : \PhpParser\Node\Expr\Assign
    {
        if ($this->isFirstCallFactory && $this->getFirstAssign() !== null) {
            return $this->createFactoryAssign();
        }
        return $this->createAssign($this->assignExpr, $this->rootExpr);
    }
    protected function createAssign(\PhpParser\Node\Expr $assignVar, \PhpParser\Node\Expr $assignExpr) : \PhpParser\Node\Expr\Assign
    {
        if ($assignVar === $assignExpr) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \PhpParser\Node\Expr\Assign($assignVar, $assignExpr);
    }
    protected function getFirstAssign() : ?\PhpParser\Node\Expr\Assign
    {
        $currentStmt = $this->assignExpr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStmt instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($currentStmt->expr instanceof \PhpParser\Node\Expr\Assign) {
            return $currentStmt->expr;
        }
        return null;
    }
    private function createFactoryAssign() : \PhpParser\Node\Expr\Assign
    {
        /** @var Assign $firstAssign */
        $firstAssign = $this->getFirstAssign();
        $currentMethodCall = $firstAssign->expr;
        if (!$currentMethodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentMethodCall = $this->resolveLastMethodCall($currentMethodCall);
        // ensure var and expr are different
        $assignVar = $firstAssign->var;
        $assignExpr = $currentMethodCall;
        return $this->createAssign($assignVar, $assignExpr);
    }
    private function resolveLastMethodCall(\PhpParser\Node\Expr\MethodCall $currentMethodCall) : \PhpParser\Node\Expr\MethodCall
    {
        while ($currentMethodCall->var instanceof \PhpParser\Node\Expr\MethodCall) {
            $currentMethodCall = $currentMethodCall->var;
        }
        return $currentMethodCall;
    }
}
