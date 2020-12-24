<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\NodeTypeResolver\Tests\NodeVisitor\FunctionMethodAndClassNodeVisitor\FunctionMethodAndClassNodeVisitorTest
 */
final class FunctionMethodAndClassNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var string|null
     */
    private $methodName;
    /**
     * @var string|null
     */
    private $className;
    /**
     * @var string|null
     */
    private $classShortName;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
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
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->processClass($node);
        $this->processMethod($node);
        $this->processFunction($node);
        $this->processClosure($node);
        return $node;
    }
    public function leaveNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            $classLike = \array_pop($this->classStack);
            $this->setClassNodeAndName($classLike);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $this->classMethod = \array_pop($this->methodStack);
            $this->methodName = (string) $this->methodName;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            $this->closure = null;
        }
        return null;
    }
    private function processClass(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $this->className);
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME, $this->classShortName);
        if ($this->classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            $this->setParentClassName($this->classLike, $node);
        }
    }
    private function processMethod(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $this->methodStack[] = $this->classMethod;
            $this->classMethod = $node;
            $this->methodName = (string) $node->name;
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, $this->methodName);
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, $this->classMethod);
    }
    private function processFunction(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
            $this->function = $node;
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE, $this->function);
    }
    private function processClosure(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            $this->closure = $node;
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE, $this->closure);
    }
    private function setClassNodeAndName(?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        $this->classLike = $classLike;
        if ($classLike === null || $classLike->name === null) {
            $this->className = null;
        } elseif (\property_exists($classLike, 'namespacedName')) {
            $this->className = $classLike->namespacedName->toString();
            $this->classShortName = $this->classNaming->getShortName($this->className);
        } else {
            $this->className = (string) $classLike->name;
            $this->classShortName = $this->classNaming->getShortName($this->className);
        }
    }
    private function setParentClassName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($class->extends === null) {
            return;
        }
        $parentClassResolvedName = $class->extends->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($parentClassResolvedName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified) {
            $parentClassResolvedName = $parentClassResolvedName->toString();
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME, $parentClassResolvedName);
    }
}
