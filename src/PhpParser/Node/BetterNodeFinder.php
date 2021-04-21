<?php

declare(strict_types=1);

namespace Rector\Core\PhpParser\Node;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeFinder;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\PackageBuilder\Php\TypeChecker;
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Core\Tests\PhpParser\Node\BetterNodeFinder\BetterNodeFinderTest
 */
final class BetterNodeFinder
{
    /**
     * @var NodeFinder
     */
    private $nodeFinder;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var TypeChecker
     */
    private $typeChecker;

    /**
     * @var NodeComparator
     */
    private $nodeComparator;

    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;

    public function __construct(
        NodeFinder $nodeFinder,
        NodeNameResolver $nodeNameResolver,
        TypeChecker $typeChecker,
        NodeComparator $nodeComparator,
        ClassAnalyzer $classAnalyzer
    ) {
        $this->nodeFinder = $nodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeChecker = $typeChecker;
        $this->nodeComparator = $nodeComparator;
        $this->classAnalyzer = $classAnalyzer;
    }

    /**
     * @template T of Node
     * @param class-string<T> $type
     * @return \PhpParser\Node|null
     */
    public function findParentType(Node $node, string $type)
    {
        Assert::isAOf($type, Node::class);

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if (! $parent instanceof Node) {
            return null;
        }

        do {
            if (is_a($parent, $type, true)) {
                return $parent;
            }

            if (! $parent instanceof Node) {
                return null;
            }
        } while ($parent = $parent->getAttribute(AttributeKey::PARENT_NODE));

        return null;
    }

    /**
     * @template T of \PhpParser\Node
     * @param array<class-string<T>> $types
     * @return \PhpParser\Node|null
     */
    public function findParentTypes(Node $node, array $types)
    {
        Assert::allIsAOf($types, Node::class);

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if (! $parent instanceof Node) {
            return null;
        }

        do {
            foreach ($types as $type) {
                if (is_a($parent, $type, true)) {
                    return $parent;
                }
            }

            if ($parent === null) {
                return null;
            }
        } while ($parent = $parent->getAttribute(AttributeKey::PARENT_NODE));

        return null;
    }

    /**
     * @template T of Node
     * @param class-string<T> $type
     * @param Node|Node[]|Stmt[] $nodes
     * @return T[]
     */
    public function findInstanceOf($nodes, string $type): array
    {
        Assert::isAOf($type, Node::class);
        return $this->nodeFinder->findInstanceOf($nodes, $type);
    }

    /**
     * @template T of Node
     * @param class-string<T> $type
     * @param Node|Node[] $nodes
     * @return \PhpParser\Node|null
     */
    public function findFirstInstanceOf($nodes, string $type)
    {
        Assert::isAOf($type, Node::class);
        return $this->nodeFinder->findFirstInstanceOf($nodes, $type);
    }

    /**
     * @param class-string<Node> $type
     * @param Node|Node[] $nodes
     */
    public function hasInstanceOfName($nodes, string $type, string $name): bool
    {
        Assert::isAOf($type, Node::class);
        return (bool) $this->findInstanceOfName($nodes, $type, $name);
    }

    /**
     * @param Node|Node[] $nodes
     */
    public function hasVariableOfName($nodes, string $name): bool
    {
        return (bool) $this->findVariableOfName($nodes, $name);
    }

    /**
     * @param Node|Node[] $nodes
     * @return \PhpParser\Node|null
     */
    public function findVariableOfName($nodes, string $name)
    {
        return $this->findInstanceOfName($nodes, Variable::class, $name);
    }

    /**
     * @param Node|Node[] $nodes
     * @param array<class-string<Node>> $types
     */
    public function hasInstancesOf($nodes, array $types): bool
    {
        Assert::allIsAOf($types, Node::class);

        foreach ($types as $type) {
            $foundNode = $this->nodeFinder->findFirstInstanceOf($nodes, $type);
            if (! $foundNode instanceof Node) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * @template T of Node
     * @param class-string<T> $type
     * @param Node|Node[] $nodes
     * @return \PhpParser\Node|null
     */
    public function findLastInstanceOf($nodes, string $type)
    {
        Assert::isAOf($type, Node::class);

        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        if ($foundInstances === []) {
            return null;
        }
        end($foundInstances);

        $lastItemKey = key($foundInstances);
        return $foundInstances[$lastItemKey];
    }

    /**
     * @param Node|Node[] $nodes
     * @return Node[]
     */
    public function find($nodes, callable $filter): array
    {
        return $this->nodeFinder->find($nodes, $filter);
    }

    /**
     * Excludes anonymous classes!
     *
     * @param Node[]|Node $nodes
     * @return ClassLike[]
     */
    public function findClassLikes($nodes): array
    {
        return $this->find($nodes, function (Node $node): bool {
            if (! $node instanceof ClassLike) {
                return false;
            }
            // skip anonymous classes
            return ! ($node instanceof Class_ && $this->classAnalyzer->isAnonymousClass($node));
        });
    }

    /**
     * @param Node[] $nodes
     * @return \PhpParser\Node|null
     */
    public function findFirstNonAnonymousClass(array $nodes)
    {
        return $this->findFirst($nodes, function (Node $node): bool {
            if (! $node instanceof ClassLike) {
                return false;
            }

            // skip anonymous classes
            return ! ($node instanceof Class_ && $this->classAnalyzer->isAnonymousClass($node));
        });
    }

    /**
     * @param Node|Node[] $nodes
     * @return \PhpParser\Node|null
     */
    public function findFirst($nodes, callable $filter)
    {
        return $this->nodeFinder->findFirst($nodes, $filter);
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function findPreviousAssignToExpr(Expr $expr)
    {
        return $this->findFirstPrevious($expr, function (Node $node) use ($expr): bool {
            if (! $node instanceof Assign) {
                return false;
            }

            return $this->nodeComparator->areNodesEqual($node->var, $expr);
        });
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function findFirstPreviousOfNode(Node $node, callable $filter)
    {
        // move to previous expression
        $previousStatement = $node->getAttribute(AttributeKey::PREVIOUS_NODE);
        if ($previousStatement !== null) {
            $foundNode = $this->findFirst([$previousStatement], $filter);
            // we found what we need
            if ($foundNode !== null) {
                return $foundNode;
            }

            return $this->findFirstPreviousOfNode($previousStatement, $filter);
        }

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if ($parent instanceof FunctionLike) {
            return null;
        }

        if ($parent instanceof Node) {
            return $this->findFirstPreviousOfNode($parent, $filter);
        }

        return null;
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function findFirstPrevious(Node $node, callable $filter)
    {
        $node = $node instanceof Expression ? $node : $node->getAttribute(AttributeKey::CURRENT_STATEMENT);
        if ($node === null) {
            return null;
        }

        $foundNode = $this->findFirst([$node], $filter);
        // we found what we need
        if ($foundNode !== null) {
            return $foundNode;
        }

        // move to previous expression
        $previousStatement = $node->getAttribute(AttributeKey::PREVIOUS_STATEMENT);
        if ($previousStatement !== null) {
            return $this->findFirstPrevious($previousStatement, $filter);
        }

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return null;
        }

        return $this->findFirstPrevious($parent, $filter);
    }

    /**
     * @template T of Node
     * @param array<class-string<T>> $types
     * @return \PhpParser\Node|null
     */
    public function findFirstPreviousOfTypes(Node $mainNode, array $types)
    {
        return $this->findFirstPrevious($mainNode, function (Node $node) use ($types): bool {
            return $this->typeChecker->isInstanceOf($node, $types);
        });
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function findFirstNext(Node $node, callable $filter)
    {
        $next = $node->getAttribute(AttributeKey::NEXT_NODE);
        if ($next instanceof Node) {
            if ($next instanceof Return_ && $next->expr === null) {
                return null;
            }

            $found = $this->findFirst($next, $filter);
            if ($found instanceof Node) {
                return $found;
            }

            return $this->findFirstNext($next, $filter);
        }

        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if ($parent instanceof Return_ || $parent instanceof FunctionLike) {
            return null;
        }

        if ($parent instanceof Node) {
            return $this->findFirstNext($parent, $filter);
        }

        return null;
    }

    /**
     * @template T of Node
     * @param Node|Node[] $nodes
     * @param class-string<T> $type
     * @return \PhpParser\Node|null
     */
    private function findInstanceOfName($nodes, string $type, string $name)
    {
        Assert::isAOf($type, Node::class);

        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        foreach ($foundInstances as $foundInstance) {
            if (! $this->nodeNameResolver->isName($foundInstance, $name)) {
                continue;
            }

            return $foundInstance;
        }

        return null;
    }
}
