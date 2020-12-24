<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
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
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\PhpParser\NodeFinder $nodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeFinder = $nodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param string|string[] $type
     */
    public function findFirstParentInstanceOf(\_PhpScopere8e811afab72\PhpParser\Node $node, $type) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $types = \is_array($type) ? $type : [$type];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsAOf($types, \_PhpScopere8e811afab72\PhpParser\Node::class);
        /** @var Node|null $parentNode */
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            return null;
        }
        do {
            if ($this->isTypes($parentNode, $types)) {
                return $parentNode;
            }
            if ($parentNode === null) {
                return null;
            }
        } while ($parentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE));
        return null;
    }
    public function findFirstAncestorInstanceOf(\_PhpScopere8e811afab72\PhpParser\Node $node, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $currentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($currentNode !== null) {
            if ($currentNode instanceof $type) {
                return $currentNode;
            }
            $currentNode = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return null;
    }
    /**
     * @param string[] $types
     */
    public function findFirstAncestorInstancesOf(\_PhpScopere8e811afab72\PhpParser\Node $node, array $types) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $currentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($currentNode !== null) {
            foreach ($types as $type) {
                if (\is_a($currentNode, $type, \true)) {
                    return $currentNode;
                }
            }
            $currentNode = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return null;
    }
    /**
     * @param Node|Node[]|Stmt[] $nodes
     * @return Node[]
     */
    public function findInstanceOf($nodes, string $type) : array
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAOf($type, \_PhpScopere8e811afab72\PhpParser\Node::class);
        return $this->nodeFinder->findInstanceOf($nodes, $type);
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function findFirstInstanceOf($nodes, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAOf($type, \_PhpScopere8e811afab72\PhpParser\Node::class);
        return $this->nodeFinder->findFirstInstanceOf($nodes, $type);
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function hasInstanceOfName($nodes, string $type, string $name) : bool
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAOf($type, \_PhpScopere8e811afab72\PhpParser\Node::class);
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
     */
    public function findVariableOfName($nodes, string $name) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->findInstanceOfName($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class, $name);
    }
    /**
     * @param Node|Node[] $nodes
     * @param class-string[] $types
     */
    public function hasInstancesOf($nodes, array $types) : bool
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsAOf($types, \_PhpScopere8e811afab72\PhpParser\Node::class);
        foreach ($types as $type) {
            $nodeFinderFindFirstInstanceOf = $this->nodeFinder->findFirstInstanceOf($nodes, $type);
            if ($nodeFinderFindFirstInstanceOf === null) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function findLastInstanceOf($nodes, string $type) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAOf($type, \_PhpScopere8e811afab72\PhpParser\Node::class);
        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        if ($foundInstances === []) {
            return null;
        }
        return \array_pop($foundInstances);
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
        return $this->find($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            // skip anonymous classes
            return !($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ && $node->isAnonymous());
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function findFirstNonAnonymousClass(array $nodes) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->findFirst($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            // skip anonymous classes
            return !($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ && $node->isAnonymous());
        });
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function findFirst($nodes, callable $filter) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->nodeFinder->findFirst($nodes, $filter);
    }
    public function findPreviousAssignToExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->findFirstPrevious($expr, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($expr) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node->var, $expr);
        });
    }
    public function findFirstPrevious(\_PhpScopere8e811afab72\PhpParser\Node $node, callable $filter) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $node = $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression ? $node : $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($node === null) {
            return null;
        }
        $foundNode = $this->findFirst([$node], $filter);
        // we found what we need
        if ($foundNode !== null) {
            return $foundNode;
        }
        // move to previous expression
        $previousStatement = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if ($previousStatement !== null) {
            return $this->findFirstPrevious($previousStatement, $filter);
        }
        $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return null;
        }
        return $this->findFirstPrevious($parent, $filter);
    }
    /**
     * @param class-string[] $types
     */
    public function findFirstPreviousOfTypes(\_PhpScopere8e811afab72\PhpParser\Node $mainNode, array $types) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->findFirstPrevious($mainNode, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($types) : bool {
            foreach ($types as $type) {
                if (!\is_a($node, $type, \true)) {
                    continue;
                }
                return \true;
            }
            return \false;
        });
    }
    /**
     * @param string[] $types
     */
    private function isTypes(\_PhpScopere8e811afab72\PhpParser\Node $node, array $types) : bool
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsAOf($types, \_PhpScopere8e811afab72\PhpParser\Node::class);
        foreach ($types as $type) {
            if (\is_a($node, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Node|Node[] $nodes
     */
    private function findInstanceOfName($nodes, string $type, string $name) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::isAOf($type, \_PhpScopere8e811afab72\PhpParser\Node::class);
        $foundInstances = $this->nodeFinder->findInstanceOf($nodes, $type);
        foreach ($foundInstances as $foundInstance) {
            if ($this->nodeNameResolver->isName($foundInstance, $name)) {
                return $foundInstance;
            }
        }
        return null;
    }
}
