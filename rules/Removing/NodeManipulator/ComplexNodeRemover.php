<?php

declare(strict_types=1);

namespace Rector\Removing\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\NodeFinder\PropertyFetchFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeRemoval\AssignRemover;
use Rector\NodeRemoval\ClassMethodRemover;
use Rector\NodeRemoval\NodeRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\NodesToRemoveCollector;

final class ComplexNodeRemover
{
    /**
     * @var NodeComparator
     */
    private $nodeComparator;

    /**
     * @var ClassMethodRemover
     */
    private $classMethodRemover;

    /**
     * @var AssignRemover
     */
    private $assignRemover;

    /**
     * @var PropertyFetchFinder
     */
    private $propertyFetchFinder;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    /**
     * @var NodeRemover
     */
    private $nodeRemover;

    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;

    public function __construct(
        ClassMethodRemover $classMethodRemover,
        AssignRemover $assignRemover,
        PropertyFetchFinder $propertyFetchFinder,
        NodeNameResolver $nodeNameResolver,
        BetterNodeFinder $betterNodeFinder,
        NodeRemover $nodeRemover,
        NodesToRemoveCollector $nodesToRemoveCollector,
        NodeComparator $nodeComparator
    ) {
        $this->classMethodRemover = $classMethodRemover;
        $this->assignRemover = $assignRemover;
        $this->propertyFetchFinder = $propertyFetchFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeRemover = $nodeRemover;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodeComparator = $nodeComparator;
    }

    /**
     * @return void
     */
    public function removeClassMethodAndUsages(ClassMethod $classMethod)
    {
        $this->classMethodRemover->removeClassMethodAndUsages($classMethod);
    }

    /**
     * @param string[] $classMethodNamesToSkip
     * @return void
     */
    public function removePropertyAndUsages(Property $property, array $classMethodNamesToSkip = [])
    {
        $shouldKeepProperty = false;

        $propertyFetches = $this->propertyFetchFinder->findPrivatePropertyFetches($property);

        foreach ($propertyFetches as $propertyFetch) {
            if ($this->shouldSkipPropertyForClassMethod($propertyFetch, $classMethodNamesToSkip)) {
                $shouldKeepProperty = true;
                continue;
            }

            // remove assigns
            $assign = $this->resolveAssign($propertyFetch);
            $this->assignRemover->removeAssignNode($assign);

            $this->removeConstructorDependency($assign);
        }

        if ($shouldKeepProperty) {
            return;
        }

        // remove __construct param

        /** @var Property $property */
        $this->nodeRemover->removeNode($property);

        foreach ($property->props as $prop) {
            if (! $this->nodesToRemoveCollector->isNodeRemoved($prop)) {
                // if the property has at least one node left -> return
                return;
            }
        }

        $this->nodeRemover->removeNode($property);
    }

    /**
     * @param StaticPropertyFetch|PropertyFetch $expr
     * @param string[] $classMethodNamesToSkip
     */
    private function shouldSkipPropertyForClassMethod(Expr $expr, array $classMethodNamesToSkip): bool
    {
        $classMethodNode = $expr->getAttribute(AttributeKey::METHOD_NODE);
        if (! $classMethodNode instanceof ClassMethod) {
            return false;
        }

        $classMethodName = $this->nodeNameResolver->getName($classMethodNode);
        return in_array($classMethodName, $classMethodNamesToSkip, true);
    }

    /**
     * @param PropertyFetch|StaticPropertyFetch $expr
     */
    private function resolveAssign(Expr $expr): Assign
    {
        $assign = $expr->getAttribute(AttributeKey::PARENT_NODE);

        while ($assign !== null && ! $assign instanceof Assign) {
            $assign = $assign->getAttribute(AttributeKey::PARENT_NODE);
        }

        if (! $assign instanceof Assign) {
            throw new ShouldNotHappenException("Can't handle this situation");
        }

        return $assign;
    }

    /**
     * @return void
     */
    private function removeConstructorDependency(Assign $assign)
    {
        $classMethod = $assign->getAttribute(AttributeKey::METHOD_NODE);
        if (! $classMethod instanceof  ClassMethod) {
            return;
        }

        if (! $this->nodeNameResolver->isName($classMethod, MethodName::CONSTRUCT)) {
            return;
        }

        $class = $assign->getAttribute(AttributeKey::CLASS_NODE);
        if (! $class instanceof Class_) {
            return;
        }

        $constructClassMethod = $class->getMethod(MethodName::CONSTRUCT);
        if (! $constructClassMethod instanceof ClassMethod) {
            return;
        }

        foreach ($constructClassMethod->getParams() as $param) {
            $variable = $this->betterNodeFinder->findFirst((array) $constructClassMethod->stmts, function (Node $node) use (
                $param
            ): bool {
                return $this->nodeComparator->areNodesEqual($param->var, $node);
            });

            if (! $variable instanceof Node) {
                continue;
            }

            if ($this->isExpressionVariableNotAssign($variable)) {
                continue;
            }

            if (! $this->nodeComparator->areNodesEqual($param->var, $assign->expr)) {
                continue;
            }

            $this->nodeRemover->removeNode($param);
        }
    }

    private function isExpressionVariableNotAssign(Node $node): bool
    {
        if ($node !== null) {
            $expressionVariable = $node->getAttribute(AttributeKey::PARENT_NODE);

            if (! $expressionVariable instanceof Assign) {
                return true;
            }
        }

        return false;
    }
}
