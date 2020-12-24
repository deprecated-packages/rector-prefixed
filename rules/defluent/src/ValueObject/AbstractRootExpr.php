<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractRootExpr implements \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\RootExprAwareInterface, \_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface
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
    public function createFirstAssign() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        if ($this->isFirstCallFactory && $this->getFirstAssign() !== null) {
            return $this->createFactoryAssign();
        }
        return $this->createAssign($this->assignExpr, $this->rootExpr);
    }
    public function createAssign(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $assignVar, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $assignExpr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        if ($assignVar === $assignExpr) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($assignVar, $assignExpr);
    }
    protected function getFirstAssign() : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        $currentStmt = $this->assignExpr->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if ($currentStmt->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return $currentStmt->expr;
        }
        return null;
    }
    private function createFactoryAssign() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        /** @var Assign $firstAssign */
        $firstAssign = $this->getFirstAssign();
        $currentMethodCall = $firstAssign->expr;
        if (!$currentMethodCall instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentMethodCall = $this->resolveLastMethodCall($currentMethodCall);
        // ensure var and expr are different
        $assignVar = $firstAssign->var;
        $assignExpr = $currentMethodCall;
        return $this->createAssign($assignVar, $assignExpr);
    }
    private function resolveLastMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $currentMethodCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        while ($currentMethodCall->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $currentMethodCall = $currentMethodCall->var;
        }
        return $currentMethodCall;
    }
}
