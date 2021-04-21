<?php

declare (strict_types=1);
namespace Rector\NodeRemoval;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\NodesToRemoveCollector;
final class NodeRemover
{
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    /**
     * @return void
     */
    public function removeNode(\PhpParser\Node $node)
    {
        // this make sure to keep just added nodes, e.g. added class constant, that doesn't have analysis of full code in this run
        // if this is missing, there are false positive e.g. for unused private constant
        $isJustAddedNode = !(bool) $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if ($isJustAddedNode) {
            return;
        }
        $this->nodesToRemoveCollector->addNodeToRemove($node);
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     * @return void
     */
    public function removeNodeFromStatements(\PhpParser\Node $nodeWithStatements, \PhpParser\Node $nodeToRemove)
    {
        foreach ((array) $nodeWithStatements->stmts as $key => $stmt) {
            if ($nodeToRemove !== $stmt) {
                continue;
            }
            unset($nodeWithStatements->stmts[$key]);
            break;
        }
    }
    /**
     * @param Node[] $nodes
     * @return void
     */
    public function removeNodes(array $nodes)
    {
        foreach ($nodes as $node) {
            $this->removeNode($node);
        }
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     * @return void
     */
    public function removeStmt(\PhpParser\Node $node, int $key)
    {
        if ($node->stmts === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->stmts[$key]);
        unset($node->stmts[$key]);
    }
    /**
     * @param int|Param $keyOrParam
     * @return void
     */
    public function removeParam(\PhpParser\Node\Stmt\ClassMethod $classMethod, $keyOrParam)
    {
        $key = $keyOrParam instanceof \PhpParser\Node\Param ? $keyOrParam->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARAMETER_POSITION) : $keyOrParam;
        if ($classMethod->params === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($classMethod->params[$key]);
        unset($classMethod->params[$key]);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     * @return void
     */
    public function removeArg(\PhpParser\Node $node, int $key)
    {
        if ($node->args === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($node->args[$key]);
        unset($node->args[$key]);
    }
    /**
     * @return void
     */
    public function removeImplements(\PhpParser\Node\Stmt\Class_ $class, int $key)
    {
        if ($class->implements === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // notify about remove node
        $this->rectorChangeCollector->notifyNodeFileInfo($class->implements[$key]);
        unset($class->implements[$key]);
    }
}
