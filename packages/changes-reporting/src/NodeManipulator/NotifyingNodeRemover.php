<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Exception\ShouldNotHappenException;
final class NotifyingNodeRemover
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    public function removeStmt(\PhpParser\Node $node, int $key) : void
    {
        if ($node->stmts === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->stmts[$key]);
        unset($node->stmts[$key]);
    }
    public function removeParam(\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        if ($classMethod->params === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($classMethod->params[$key]);
        unset($classMethod->params[$key]);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    public function removeArg(\PhpParser\Node $node, int $key) : void
    {
        if ($node->args === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->args[$key]);
        unset($node->args[$key]);
    }
    public function removeImplements(\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        if ($class->implements === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($class->implements[$key]);
        unset($class->implements[$key]);
    }
}
