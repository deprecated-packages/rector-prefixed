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
final class FirstAssignFluentCall implements \Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
{
    /**
     * @var bool
     */
    private $isFirstCallFactory = \false;
    /**
     * @var Expr
     */
    private $assignExpr;
    /**
     * @var Expr
     */
    private $rootExpr;
    /**
     * @var FluentMethodCalls
     */
    private $fluentMethodCalls;
    public function __construct(\PhpParser\Node\Expr $assignExpr, \PhpParser\Node\Expr $rootExpr, bool $isFirstCallFactory, \Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls)
    {
        $this->assignExpr = $assignExpr;
        $this->rootExpr = $rootExpr;
        $this->isFirstCallFactory = $isFirstCallFactory;
        $this->fluentMethodCalls = $fluentMethodCalls;
    }
    public function getAssignExpr() : \PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function getRootExpr() : \PhpParser\Node\Expr
    {
        return $this->rootExpr;
    }
    public function createFirstAssign() : \PhpParser\Node\Expr\Assign
    {
        if ($this->isFirstCallFactory && $this->getFirstAssign() !== null) {
            return $this->createFactoryAssign();
        }
        return $this->createAssign($this->assignExpr, $this->rootExpr);
    }
    public function getCallerExpr() : \PhpParser\Node\Expr
    {
        return $this->assignExpr;
    }
    public function isFirstCallFactory() : bool
    {
        return $this->isFirstCallFactory;
    }
    public function getFactoryAssignVariable() : \PhpParser\Node\Expr
    {
        $firstAssign = $this->getFirstAssign();
        if ($firstAssign === null) {
            return $this->assignExpr;
        }
        return $firstAssign->var;
    }
    /**
     * @return MethodCall[]
     */
    public function getFluentMethodCalls() : array
    {
        return $this->fluentMethodCalls->getFluentMethodCalls();
    }
    private function getFirstAssign() : ?\PhpParser\Node\Expr\Assign
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
        $currentMethodCall = $this->fluentMethodCalls->getLastMethodCall();
        // ensure var and expr are different
        $assignVar = $firstAssign->var;
        $assignExpr = $currentMethodCall;
        return $this->createAssign($assignVar, $assignExpr);
    }
    private function createAssign(\PhpParser\Node\Expr $assignVar, \PhpParser\Node\Expr $assignExpr) : \PhpParser\Node\Expr\Assign
    {
        if ($assignVar === $assignExpr) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \PhpParser\Node\Expr\Assign($assignVar, $assignExpr);
    }
}
