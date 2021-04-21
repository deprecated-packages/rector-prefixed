<?php

declare(strict_types=1);

namespace Rector\Doctrine\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PhpParser\NodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeRemoval\NodeRemover;
use Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;

final class DependencyRemover
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;

    /**
     * @var NodeRemover
     */
    private $nodeRemover;

    public function __construct(
        NodeNameResolver $nodeNameResolver,
        SimpleCallableNodeTraverser $simpleCallableNodeTraverser,
        NodeRemover $nodeRemover
    ) {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeRemover = $nodeRemover;
    }

    /**
     * @return void
     */
    public function removeByType(
        Class_ $class,
        ClassMethod $classMethod,
        Param $registryParam,
        string $type
    ) {
        // remove constructor param: $managerRegistry
        foreach ($classMethod->params as $key => $param) {
            if ($param->type === null) {
                continue;
            }

            if (! $this->nodeNameResolver->isName($param->type, $type)) {
                continue;
            }

            unset($classMethod->params[$key]);
        }

        $this->removeRegistryDependencyAssign($class, $classMethod, $registryParam);
    }

    /**
     * @return void
     */
    private function removeRegistryDependencyAssign(Class_ $class, ClassMethod $classMethod, Param $registryParam)
    {
        foreach ((array) $classMethod->stmts as $constructorMethodStmt) {
            if (! $constructorMethodStmt instanceof Expression) {
                continue;
            }

            if (! $constructorMethodStmt->expr instanceof Assign) {
                continue;
            }

            /** @var Assign $assign */
            $assign = $constructorMethodStmt->expr;
            if (! $this->nodeNameResolver->areNamesEqual($assign->expr, $registryParam->var)) {
                continue;
            }

            $this->removeManagerRegistryProperty($class, $assign);

            // remove assign
            $this->nodeRemover->removeNodeFromStatements($classMethod, $constructorMethodStmt);

            break;
        }
    }

    /**
     * @return void
     */
    private function removeManagerRegistryProperty(Class_ $class, Assign $assign)
    {
        $removedPropertyName = $this->nodeNameResolver->getName($assign->var);
        if ($removedPropertyName === null) {
            return;
        }

        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($class->stmts, function (Node $node) use (
            $removedPropertyName
        ): ?int {
            if (! $node instanceof Property) {
                return null;
            }

            if (! $this->nodeNameResolver->isName($node, $removedPropertyName)) {
                return null;
            }

            $this->nodeRemover->removeNode($node);

            return NodeTraverser::STOP_TRAVERSAL;
        });
    }
}
