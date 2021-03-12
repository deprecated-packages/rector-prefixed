<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeVisitorAbstract;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionMethodAndClassNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /**
     * @var string|null
     */
    private $methodName;
    /**
     * @var string|null
     */
    private $className;
    /**
     * @var ClassLike[]|null[]
     */
    private $classStack = [];
    /**
     * @var ClassMethod[]|null[]
     */
    private $methodStack = [];
    /**
     * @var ClassLike|null
     */
    private $classLike;
    /**
     * @var ClassMethod|null
     */
    private $classMethod;
    /**
     * @var Function_|null
     */
    private $function;
    /**
     * @var Closure|null
     */
    private $closure;
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->classLike = null;
        $this->className = null;
        $this->methodName = null;
        $this->classMethod = null;
        $this->function = null;
        $this->closure = null;
        return null;
    }
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->processClass($node);
        $this->processMethod($node);
        $this->processFunction($node);
        $this->processClosure($node);
        return $node;
    }
    public function leaveNode(\PhpParser\Node $node)
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            $classLike = \array_pop($this->classStack);
            $this->setClassNodeAndName($classLike);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->classMethod = \array_pop($this->methodStack);
            $this->methodName = (string) $this->methodName;
        }
        if ($node instanceof \PhpParser\Node\Expr\Closure) {
            $this->closure = null;
        }
        return null;
    }
    private function processClass(\PhpParser\Node $node) : void
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $this->className);
        if ($this->classLike instanceof \PhpParser\Node\Stmt\Class_) {
            $this->setParentClassName($this->classLike, $node);
        }
    }
    private function processMethod(\PhpParser\Node $node) : void
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->methodStack[] = $this->classMethod;
            $this->classMethod = $node;
            $this->methodName = (string) $node->name;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, $this->methodName);
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, $this->classMethod);
    }
    private function processFunction(\PhpParser\Node $node) : void
    {
        if ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $this->function = $node;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE, $this->function);
    }
    private function processClosure(\PhpParser\Node $node) : void
    {
        if ($node instanceof \PhpParser\Node\Expr\Closure) {
            $this->closure = $node;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE, $this->closure);
    }
    private function setClassNodeAndName(?\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        $this->classLike = $classLike;
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike || $classLike->name === null) {
            $this->className = null;
        } elseif (\property_exists($classLike, 'namespacedName')) {
            $this->className = $classLike->namespacedName->toString();
        } else {
            $this->className = (string) $classLike->name;
        }
    }
    private function setParentClassName(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node $node) : void
    {
        if ($class->extends === null) {
            return;
        }
        $parentClassResolvedName = $class->extends->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($parentClassResolvedName instanceof \PhpParser\Node\Name\FullyQualified) {
            $parentClassResolvedName = $parentClassResolvedName->toString();
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME, $parentClassResolvedName);
    }
}
