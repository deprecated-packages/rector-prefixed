<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
final class NotifyingNodeRemover
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    public function removeStmt(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $key) : void
    {
        if ($node->stmts === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->stmts[$key]);
        unset($node->stmts[$key]);
    }
    public function removeParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        if ($classMethod->params === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($classMethod->params[$key]);
        unset($classMethod->params[$key]);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    public function removeArg(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $key) : void
    {
        if ($node->args === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->args[$key]);
        unset($node->args[$key]);
    }
    public function removeImplements(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        if ($class->implements === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($class->implements[$key]);
        unset($class->implements[$key]);
    }
}
