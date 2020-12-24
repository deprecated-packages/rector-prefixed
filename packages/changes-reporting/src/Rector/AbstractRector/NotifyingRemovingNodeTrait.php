<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Rector\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover;
trait NotifyingRemovingNodeTrait
{
    /**
     * @var NotifyingNodeRemover
     */
    private $notifyingNodeRemover;
    /**
     * @required
     */
    public function autowireNotifyingRemovingNodeTrait(\_PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover $notifyingNodeRemover) : void
    {
        $this->notifyingNodeRemover = $notifyingNodeRemover;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    protected function removeStmt(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeStmt($node, $key);
    }
    protected function removeParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        $this->notifyingNodeRemover->removeParam($classMethod, $key);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    protected function removeArg(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeArg($node, $key);
    }
    protected function removeImplements(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $this->notifyingNodeRemover->removeImplements($class, $key);
    }
}
