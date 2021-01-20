<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\ChildPopulator;

use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\Type;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ChildReturnPopulator extends \Rector\TypeDeclaration\ChildPopulator\AbstractChildPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children class methods
     */
    public function populateChildren(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $childrenClassLikes = $this->nodeRepository->findChildrenOfClass($className);
        if ($childrenClassLikes === []) {
            return;
        }
        // update their methods as well
        foreach ($childrenClassLikes as $childClassLike) {
            $usedTraits = $this->nodeRepository->findUsedTraitsInClass($childClassLike);
            foreach ($usedTraits as $trait) {
                $this->addReturnTypeToChildMethod($trait, $classMethod, $returnType);
            }
            $this->addReturnTypeToChildMethod($childClassLike, $classMethod, $returnType);
        }
    }
    private function addReturnTypeToChildMethod(\PhpParser\Node\Stmt\ClassLike $classLike, \PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $currentClassMethod = $classLike->getMethod($methodName);
        if (!$currentClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        $resolvedChildTypeNode = $this->resolveChildTypeNode($returnType);
        if ($resolvedChildTypeNode === null) {
            return;
        }
        $currentClassMethod->returnType = $resolvedChildTypeNode;
        // make sure the type is not overridden
        $currentClassMethod->returnType->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE, \true);
    }
}
