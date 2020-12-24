<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\ChildPopulator;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ChildReturnPopulator extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\ChildPopulator\AbstractChildPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children class methods
     */
    public function populateChildren(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $className = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
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
    private function addReturnTypeToChildMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $currentClassMethod = $classLike->getMethod($methodName);
        if ($currentClassMethod === null) {
            return;
        }
        $resolvedChildTypeNode = $this->resolveChildTypeNode($returnType);
        if ($resolvedChildTypeNode === null) {
            return;
        }
        $currentClassMethod->returnType = $resolvedChildTypeNode;
        // make sure the type is not overridden
        $currentClassMethod->returnType->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE, \true);
    }
}
