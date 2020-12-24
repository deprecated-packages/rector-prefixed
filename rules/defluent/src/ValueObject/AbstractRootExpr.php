<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractRootExpr implements \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScopere8e811afab72\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
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
    public function createFirstAssign() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        if ($this->isFirstCallFactory && $this->getFirstAssign() !== null) {
            return $this->createFactoryAssign();
        }
        return $this->createAssign($this->assignExpr, $this->rootExpr);
    }
    public function createAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr $assignVar, \_PhpScopere8e811afab72\PhpParser\Node\Expr $assignExpr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        if ($assignVar === $assignExpr) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($assignVar, $assignExpr);
    }
    protected function getFirstAssign() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        $currentStmt = $this->assignExpr->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($currentStmt->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return $currentStmt->expr;
        }
        return null;
    }
    private function createFactoryAssign() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        /** @var Assign $firstAssign */
        $firstAssign = $this->getFirstAssign();
        $currentMethodCall = $firstAssign->expr;
        if (!$currentMethodCall instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentMethodCall = $this->resolveLastMethodCall($currentMethodCall);
        // ensure var and expr are different
        $assignVar = $firstAssign->var;
        $assignExpr = $currentMethodCall;
        return $this->createAssign($assignVar, $assignExpr);
    }
    private function resolveLastMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $currentMethodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        while ($currentMethodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $currentMethodCall = $currentMethodCall->var;
        }
        return $currentMethodCall;
    }
}
