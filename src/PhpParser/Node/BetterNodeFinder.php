<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeFinder;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210313\Symplify\PackageBuilder\Php\TypeChecker;
use RectorPrefix20210313\Webmozart\Assert\Assert;
/**
 * @template T of Node
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
    public function __construct(\PhpParser\NodeFinder $nodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20210313\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->nodeFinder = $nodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeChecker = $typeChecker;
        $this->nodeComparator = $nodeComparator;
    }
    /**
     * @param class-string<T> $type
     * @return T|null
     */
    public function findParentType(\PhpParser\Node $node, string $type) : ?\PhpParser\Node
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node) {
            return null;
        }
        do {
            if (\is_a($parent, $type, \true)) {
                return $parent;
            }
            if (!$parent instanceof \PhpParser\Node) {
                return null;
            }
        } while ($parent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE));
        return null;
    }
    /**
     * @param class-string<T>[] $types
     * @return T|null
     */
    public function findParentTypes(\PhpParser\Node $node, array $types) : ?\PhpParser\Node
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::allIsAOf($types, \PhpParser\Node::class);
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node) {
            return null;
        }
        do {
            if (\Rector\Core\Util\StaticInstanceOf::isOneOf($parent, $types)) {
                return $parent;
            }
            if ($parent === null) {
                return null;
            }
        } while ($parent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE));
        return null;
    }
    /**
     * @param class-string<T> $type
     * @return T|null
     */
    public function findFirstAncestorInstanceOf(\PhpParser\Node $node, string $type) : ?\PhpParser\Node
    {
        $currentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($currentNode !== null) {
            if ($currentNode instanceof $type) {
                return $currentNode;
            }
            $currentNode = $currentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return null;
    }
    /**
     * @param array<class-string<T>> $types
     * @return T|null
     */
    public function findFirstAncestorInstancesOf(\PhpParser\Node $node, array $types) : ?\PhpParser\Node
    {
        $currentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($currentNode instanceof \PhpParser\Node) {
            foreach ($types as $type) {
                if (\is_a($currentNode, $type, \true)) {
                    return $currentNode;
                }
            }
            $currentNode = $currentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return null;
    }
    /**
     * @param class-string<T> $type
     * @param Node|Node[]|Stmt[] $nodes
     * @return T[]
     */
    public function findInstanceOf($nodes, string $type) : array
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        return $this->nodeFinder->findInstanceOf($nodes, $type);
    }
    /**
     * @param class-string<T> $type
     * @param Node|Node[] $nodes
     * @return T|null
     */
    public function findFirstInstanceOf($nodes, string $type) : ?\PhpParser\Node
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        return $this->nodeFinder->findFirstInstanceOf($nodes, $type);
    }
    /**
     * @param class-string<T> $type
     * @param Node|Node[] $nodes
     */
    public function hasInstanceOfName($nodes, string $type, string $name) : bool
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        return (bool) $this->findInstanceOfName($nodes, $type, $name);
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function hasVariableOfName($nodes, string $name) : bool
    {
        return (bool) $this->findVariableOfName($nodes, $name);
    }
    /**
     * @param Node|Node[] $nodes
     * @return Variable|null
     */
    public function findVariableOfName($nodes, string $name) : ?\PhpParser\Node
    {
        return $this->findInstanceOfName($nodes, \PhpParser\Node\Expr\Variable::class, $name);
    }
    /**
     * @param Node|Node[] $nodes
     * @param class-string<T>[] $types
     */
    public function hasInstancesOf($nodes, array $types) : bool
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::allIsAOf($types, \PhpParser\Node::class);
        foreach ($types as $type) {
            $nodeFinderFindFirstInstanceOf = $this->nodeFinder->findFirstInstanceOf($nodes, $type);
            if (!$nodeFinderFindFirstInstanceOf instanceof \PhpParser\Node) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param class-string<T> $type
     * @param Node|Node[] $nodes
     * @return T|null
     */
    public function findLastInstanceOf($nodes, string $type) : ?\PhpParser\Node
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        if ($foundInstances === []) {
            return null;
        }
        $lastItemKey = \array_key_last($foundInstances);
        return $foundInstances[$lastItemKey];
    }
    /**
     * @param Node|Node[] $nodes
     * @return Node[]
     */
    public function find($nodes, callable $filter) : array
    {
        return $this->nodeFinder->find($nodes, $filter);
    }
    /**
     * Excludes anonymous classes!
     *
     * @param Node[]|Node $nodes
     * @return ClassLike[]
     */
    public function findClassLikes($nodes) : array
    {
        return $this->find($nodes, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            // skip anonymous classes
            return !($node instanceof \PhpParser\Node\Stmt\Class_ && $node->isAnonymous());
        });
    }
    /**
     * @param Node[] $nodes
     * @return ClassLike|null
     */
    public function findFirstNonAnonymousClass(array $nodes) : ?\PhpParser\Node
    {
        return $this->findFirst($nodes, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            // skip anonymous classes
            return !($node instanceof \PhpParser\Node\Stmt\Class_ && $node->isAnonymous());
        });
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function findFirst($nodes, callable $filter) : ?\PhpParser\Node
    {
        return $this->nodeFinder->findFirst($nodes, $filter);
    }
    /**
     * @return Assign|null
     */
    public function findPreviousAssignToExpr(\PhpParser\Node\Expr $expr) : ?\PhpParser\Node
    {
        return $this->findFirstPrevious($expr, function (\PhpParser\Node $node) use($expr) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            return $this->nodeComparator->areNodesEqual($node->var, $expr);
        });
    }
    public function findFirstPreviousOfNode(\PhpParser\Node $node, callable $filter) : ?\PhpParser\Node
    {
        // move to previous expression
        $previousStatement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($previousStatement !== null) {
            $foundNode = $this->findFirst([$previousStatement], $filter);
            // we found what we need
            if ($foundNode !== null) {
                return $foundNode;
            }
            return $this->findFirstPreviousOfNode($previousStatement, $filter);
        }
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \PhpParser\Node) {
            return $this->findFirstPreviousOfNode($parent, $filter);
        }
        return null;
    }
    public function findFirstPrevious(\PhpParser\Node $node, callable $filter) : ?\PhpParser\Node
    {
        $node = $node instanceof \PhpParser\Node\Stmt\Expression ? $node : $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($node === null) {
            return null;
        }
        $foundNode = $this->findFirst([$node], $filter);
        // we found what we need
        if ($foundNode !== null) {
            return $foundNode;
        }
        // move to previous expression
        $previousStatement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if ($previousStatement !== null) {
            return $this->findFirstPrevious($previousStatement, $filter);
        }
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return null;
        }
        return $this->findFirstPrevious($parent, $filter);
    }
    /**
     * @param class-string<T>[] $types
     * @return T|null
     */
    public function findFirstPreviousOfTypes(\PhpParser\Node $mainNode, array $types) : ?\PhpParser\Node
    {
        return $this->findFirstPrevious($mainNode, function (\PhpParser\Node $node) use($types) : bool {
            return $this->typeChecker->isInstanceOf($node, $types);
        });
    }
    public function findFirstNext(\PhpParser\Node $node, callable $filter) : ?\PhpParser\Node
    {
        $next = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($next instanceof \PhpParser\Node) {
            $found = $this->findFirst($next, $filter);
            if ($found instanceof \PhpParser\Node) {
                return $found;
            }
            return $this->findFirstNext($next, $filter);
        }
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \PhpParser\Node) {
            return $this->findFirstNext($parent, $filter);
        }
        return null;
    }
    /**
     * @param Node|Node[] $nodes
     * @param class-string<T> $type
     * @return T|null
     */
    private function findInstanceOfName($nodes, string $type, string $name) : ?\PhpParser\Node
    {
        \RectorPrefix20210313\Webmozart\Assert\Assert::isAOf($type, \PhpParser\Node::class);
        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        foreach ($foundInstances as $foundInstance) {
            if (!$this->nodeNameResolver->isName($foundInstance, $name)) {
                continue;
            }
            return $foundInstance;
        }
        return null;
    }
}
