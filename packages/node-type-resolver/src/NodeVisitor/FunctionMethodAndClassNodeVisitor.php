<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\NodeTypeResolver\Tests\NodeVisitor\FunctionMethodAndClassNodeVisitor\FunctionMethodAndClassNodeVisitorTest
 */
final class FunctionMethodAndClassNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming)
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
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $this->processClass($node);
        $this->processMethod($node);
        $this->processFunction($node);
        $this->processClosure($node);
        return $node;
    }
    public function leaveNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
            $classLike = \array_pop($this->classStack);
            $this->setClassNodeAndName($classLike);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->classMethod = \array_pop($this->methodStack);
            $this->methodName = (string) $this->methodName;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure) {
            $this->closure = null;
        }
        return null;
    }
    private function processClass(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $this->className);
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME, $this->classShortName);
        if ($this->classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            $this->setParentClassName($this->classLike, $node);
        }
    }
    private function processMethod(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->methodStack[] = $this->classMethod;
            $this->classMethod = $node;
            $this->methodName = (string) $node->name;
        }
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, $this->methodName);
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, $this->classMethod);
    }
    private function processFunction(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_) {
            $this->function = $node;
        }
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE, $this->function);
    }
    private function processClosure(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure) {
            $this->closure = $node;
        }
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE, $this->closure);
    }
    private function setClassNodeAndName(?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : void
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
    private function setParentClassName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($class->extends === null) {
            return;
        }
        $parentClassResolvedName = $class->extends->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($parentClassResolvedName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
            $parentClassResolvedName = $parentClassResolvedName->toString();
        }
        $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME, $parentClassResolvedName);
    }
}
