<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover;
trait NotifyingRemovingNodeTrait
{
    /**
     * @var NotifyingNodeRemover
     */
    private $notifyingNodeRemover;
    /**
     * @required
     */
    public function autowireNotifyingRemovingNodeTrait(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\NodeManipulator\NotifyingNodeRemover $notifyingNodeRemover) : void
    {
        $this->notifyingNodeRemover = $notifyingNodeRemover;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    protected function removeStmt(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeStmt($node, $key);
    }
    protected function removeParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        $this->notifyingNodeRemover->removeParam($classMethod, $key);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    protected function removeArg(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $key) : void
    {
        $this->notifyingNodeRemover->removeArg($node, $key);
    }
    protected function removeImplements(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $this->notifyingNodeRemover->removeImplements($class, $key);
    }
}
