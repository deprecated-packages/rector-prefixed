<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ChangesReporting\NodeManipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
final class NotifyingNodeRemover
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    public function removeStmt(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, int $key) : void
    {
        if ($node->stmts === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->stmts[$key]);
        unset($node->stmts[$key]);
    }
    public function removeParam(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, int $key) : void
    {
        if ($classMethod->params === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($classMethod->params[$key]);
        unset($classMethod->params[$key]);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    public function removeArg(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, int $key) : void
    {
        if ($node->args === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->args[$key]);
        unset($node->args[$key]);
    }
    public function removeImplements(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        if ($class->implements === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($class->implements[$key]);
        unset($class->implements[$key]);
    }
}
