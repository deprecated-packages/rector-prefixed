<?php

declare(strict_types=1);

namespace Rector\TypeDeclaration\ChildPopulator;

use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\Type;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\NodeTypeAnalyzer\ChildTypeResolver;

final class ChildReturnPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * @var ChildTypeResolver
     */
    private $childTypeResolver;

    public function __construct(
        NodeNameResolver $nodeNameResolver,
        NodeRepository $nodeRepository,
        ChildTypeResolver $childTypeResolver
    ) {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeRepository = $nodeRepository;
        $this->childTypeResolver = $childTypeResolver;
    }

    /**
     * Add typehint to all children class methods
     * @return void
     */
    public function populateChildren(ClassMethod $classMethod, Type $returnType)
    {
        $className = $classMethod->getAttribute(AttributeKey::CLASS_NAME);
        if (! is_string($className)) {
            throw new ShouldNotHappenException();
        }

        $childrenClassLikes = $this->nodeRepository->findChildrenOfClass($className);
        if ($childrenClassLikes === []) {
            return;
        }

        // update their methods as well
        foreach ($childrenClassLikes as $childClassLike) {
            $usedTraits = $this->nodeRepository->findUsedTraitsInClass($childClassLike);
            foreach ($usedTraits as $usedTrait) {
                $this->addReturnTypeToChildMethod($usedTrait, $classMethod, $returnType);
            }

            $this->addReturnTypeToChildMethod($childClassLike, $classMethod, $returnType);
        }
    }

    /**
     * @return void
     */
    private function addReturnTypeToChildMethod(
        ClassLike $classLike,
        ClassMethod $classMethod,
        Type $returnType
    ) {
        $methodName = $this->nodeNameResolver->getName($classMethod);

        $currentClassMethod = $classLike->getMethod($methodName);
        if (! $currentClassMethod instanceof ClassMethod) {
            return;
        }

        $resolvedChildTypeNode = $this->childTypeResolver->resolveChildTypeNode($returnType);
        if ($resolvedChildTypeNode === null) {
            return;
        }

        $currentClassMethod->returnType = $resolvedChildTypeNode;

        // make sure the type is not overridden
        $currentClassMethod->returnType->setAttribute(AttributeKey::DO_NOT_CHANGE, true);
    }
}
