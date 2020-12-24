<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ChildAndParentClassManipulator
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add "parent::__construct()" where needed
     */
    public function completeParentConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var string|null $parentClassName */
        $parentClassName = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return;
        }
        // not in analyzed scope, nothing we can do
        $parentClassNode = $this->parsedNodeCollector->findClass($parentClassName);
        if ($parentClassNode !== null) {
            $this->completeParentConstructorBasedOnParentNode($parentClassNode, $classMethod);
            return;
        }
        // complete parent call for __construct()
        if ($parentClassName !== '' && \method_exists($parentClassName, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            $staticCall = $this->nodeFactory->createParentConstructWithParams([]);
            $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($staticCall);
        }
    }
    public function completeChildConstructors(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $constructorClassMethod) : void
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return;
        }
        $childClassNodes = $this->nodeRepository->findChildrenOfClass($className);
        foreach ($childClassNodes as $childClassNode) {
            $childConstructorClassMethod = $childClassNode->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            if ($childConstructorClassMethod === null) {
                continue;
            }
            // replicate parent parameters
            $childConstructorClassMethod->params = \array_merge($constructorClassMethod->params, $childConstructorClassMethod->params);
            $parentConstructCallNode = $this->nodeFactory->createParentConstructWithParams($constructorClassMethod->params);
            $childConstructorClassMethod->stmts = \array_merge([new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($parentConstructCallNode)], (array) $childConstructorClassMethod->stmts);
        }
    }
    private function completeParentConstructorBasedOnParentNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $parentClassNode, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $firstParentConstructMethodNode = $this->findFirstParentConstructor($parentClassNode);
        if ($firstParentConstructMethodNode === null) {
            return;
        }
        // replicate parent parameters
        $classMethod->params = \array_merge($firstParentConstructMethodNode->params, $classMethod->params);
        $staticCall = $this->nodeFactory->createParentConstructWithParams($firstParentConstructMethodNode->params);
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($staticCall);
    }
    private function findFirstParentConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        while ($class !== null) {
            $constructMethodNode = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            if ($constructMethodNode !== null) {
                return $constructMethodNode;
            }
            /** @var string|null $parentClassName */
            $parentClassName = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
            if ($parentClassName === null) {
                return null;
            }
            $class = $this->parsedNodeCollector->findClass($parentClassName);
        }
        return null;
    }
}
