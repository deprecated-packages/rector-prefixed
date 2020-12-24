<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractRootExpr implements \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
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
    public function createFirstAssign() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        if ($this->isFirstCallFactory && $this->getFirstAssign() !== null) {
            return $this->createFactoryAssign();
        }
        return $this->createAssign($this->assignExpr, $this->rootExpr);
    }
    public function createAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $assignVar, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $assignExpr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        if ($assignVar === $assignExpr) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($assignVar, $assignExpr);
    }
    protected function getFirstAssign() : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $currentStmt = $this->assignExpr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($currentStmt->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return $currentStmt->expr;
        }
        return null;
    }
    private function createFactoryAssign() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        /** @var Assign $firstAssign */
        $firstAssign = $this->getFirstAssign();
        $currentMethodCall = $firstAssign->expr;
        if (!$currentMethodCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentMethodCall = $this->resolveLastMethodCall($currentMethodCall);
        // ensure var and expr are different
        $assignVar = $firstAssign->var;
        $assignExpr = $currentMethodCall;
        return $this->createAssign($assignVar, $assignExpr);
    }
    private function resolveLastMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $currentMethodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        while ($currentMethodCall->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            $currentMethodCall = $currentMethodCall->var;
        }
        return $currentMethodCall;
    }
}
