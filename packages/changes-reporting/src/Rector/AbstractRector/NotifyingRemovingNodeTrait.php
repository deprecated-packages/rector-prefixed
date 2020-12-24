<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ChangesReporting\Rector\AbstractRector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover;
trait NotifyingRemovingNodeTrait
{
    /**
     * @var NotifyingNodeRemover
     */
    private $notifyingNodeRemover;
    /**
     * @required
     */
    public function autowireNotifyingRemovingNodeTrait(\_PhpScoper0a6b37af0871\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover $notifyingNodeRemover) : void
    {
        $this->notifyingNodeRemover = $notifyingNodeRemover;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    protected function removeStmt(\_PhpScoper0a6b37af0871\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeStmt($node, $key);
    }
    protected function removeParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        $this->notifyingNodeRemover->removeParam($classMethod, $key);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    protected function removeArg(\_PhpScoper0a6b37af0871\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeArg($node, $key);
    }
    protected function removeImplements(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $this->notifyingNodeRemover->removeImplements($class, $key);
    }
}
