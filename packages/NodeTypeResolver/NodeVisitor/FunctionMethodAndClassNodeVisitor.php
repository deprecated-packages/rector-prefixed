<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
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
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse($nodes) : ?array
    {
        $this->classLike = null;
        $this->className = null;
        $this->methodName = null;
        $this->classMethod = null;
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function enterNode($node) : ?\PhpParser\Node
    {
        $this->processClass($node);
        $this->processMethod($node);
        return $node;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function leaveNode($node)
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            $classLike = \array_pop($this->classStack);
            $this->setClassNodeAndName($classLike);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->classMethod = \array_pop($this->methodStack);
            $this->methodName = (string) $this->methodName;
        }
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function processClass($node) : void
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $this->className);
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function processMethod($node) : void
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->methodStack[] = $this->classMethod;
            $this->classMethod = $node;
            $this->methodName = (string) $node->name;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, $this->methodName);
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, $this->classMethod);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassLike|null $classLike
     */
    private function setClassNodeAndName($classLike) : void
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
}
