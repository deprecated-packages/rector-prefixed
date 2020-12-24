<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ChildReturnPopulator extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator\AbstractChildPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children class methods
     */
    public function populateChildren(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $className = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
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
    private function addReturnTypeToChildMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType) : void
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
        $currentClassMethod->returnType->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE, \true);
    }
}
