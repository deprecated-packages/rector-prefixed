<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover;
/**
 * @deprecated Use NodeRemover directly
 */
trait NotifyingRemovingNodeTrait
{
    /**
     * @var NotifyingNodeRemover
     */
    private $notifyingNodeRemover;
    /**
     * @required
     */
    public function autowireNotifyingRemovingNodeTrait(\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover $notifyingNodeRemover) : void
    {
        $this->notifyingNodeRemover = $notifyingNodeRemover;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    protected function removeStmt(\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeStmt($node, $key);
    }
    protected function removeParam(\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        $this->notifyingNodeRemover->removeParam($classMethod, $key);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    protected function removeArg(\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeArg($node, $key);
    }
    protected function removeImplements(\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $this->notifyingNodeRemover->removeImplements($class, $key);
    }
}
