<?php

declare(strict_types=1);

namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;
use Rector\NodeTypeResolver\Node\AttributeKey;

final class FunctionMethodAndClassNodeVisitor extends NodeVisitorAbstract
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
    public function enterNode(Node $node)
    {
        $this->processClass($node);
        $this->processMethod($node);

        return $node;
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassLike) {
            $classLike = array_pop($this->classStack);
            $this->setClassNodeAndName($classLike);
        }

        if ($node instanceof ClassMethod) {
            $this->classMethod = array_pop($this->methodStack);
        }

        return null;
    }

    /**
     * @return void
     */
    private function processClass(Node $node)
    {
        if ($node instanceof ClassLike) {
            $this->classStack[] = $this->classLike;
            $this->setClassNodeAndName($node);
        }

        $node->setAttribute(AttributeKey::CLASS_NODE, $this->classLike);
        $node->setAttribute(AttributeKey::CLASS_NAME, $this->className);
    }

    /**
     * @return void
     */
    private function processMethod(Node $node)
    {
        if ($node instanceof ClassMethod) {
            $this->methodStack[] = $this->classMethod;

            $this->classMethod = $node;
        }

        $node->setAttribute(AttributeKey::METHOD_NODE, $this->classMethod);
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassLike|null $classLike
     * @return void
     */
    private function setClassNodeAndName($classLike)
    {
        $this->classLike = $classLike;
        if (! $classLike instanceof ClassLike || $classLike->name === null) {
            $this->className = null;
        } elseif (property_exists($classLike, 'namespacedName')) {
            $this->className = $classLike->namespacedName->toString();
        } else {
            $this->className = (string) $classLike->name;
        }
    }
}
