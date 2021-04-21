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
     * @return mixed[]|null
     */
    public function beforeTraverse(array $nodes)
    {
        $this->classLike = null;
        $this->className = null;
        $this->classMethod = null;
        return null;
    }
    /**
     * @return \PhpParser\Node|null
     */
    public function enterNode(\PhpParser\Node $node)
    {
        $this->processClass($node);
        $this->processMethod($node);
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
        }
        return null;
    }
    /**
     * @return void
     */
    private function processClass(\PhpParser\Node $node)
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $this->className);
    }
    /**
     * @return void
     */
    private function processMethod(\PhpParser\Node $node)
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->methodStack[] = $this->classMethod;
            $this->classMethod = $node;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, $this->classMethod);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassLike|null $classLike
     * @return void
     */
    private function setClassNodeAndName($classLike)
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
