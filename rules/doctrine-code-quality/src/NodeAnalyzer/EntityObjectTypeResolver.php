<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\NodeAnalyzer;

use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\DoctrineCodeQuality\TypeAnalyzer\TypeFinder;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class EntityObjectTypeResolver
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var TypeFinder
     */
    private $typeFinder;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\DoctrineCodeQuality\TypeAnalyzer\TypeFinder $typeFinder, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->typeFinder = $typeFinder;
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function resolveFromRepositoryClass(\PhpParser\Node\Stmt\Class_ $repositoryClass) : \PHPStan\Type\Type
    {
        $getterReturnType = $this->resolveFromGetterReturnType($repositoryClass);
        if ($getterReturnType instanceof \PHPStan\Type\Type) {
            return $getterReturnType;
        }
        $entityType = $this->resolveFromMatchingEntityAnnotation($repositoryClass);
        if ($entityType instanceof \PHPStan\Type\Type) {
            return $entityType;
        }
        return new \PHPStan\Type\MixedType();
    }
    private function resolveFromGetterReturnType(\PhpParser\Node\Stmt\Class_ $repositoryClass) : ?\PHPStan\Type\Type
    {
        foreach ($repositoryClass->getMethods() as $classMethod) {
            if (!$classMethod->isPublic()) {
                continue;
            }
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
            $returnType = $phpDocInfo->getReturnType();
            $objectType = $this->typeFinder->find($returnType, \PHPStan\Type\ObjectType::class);
            if (!$objectType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            return $objectType;
        }
        return null;
    }
    private function resolveFromMatchingEntityAnnotation(\PhpParser\Node\Stmt\Class_ $repositoryClass) : ?\PHPStan\Type\ObjectType
    {
        $repositoryClassName = $repositoryClass->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($this->nodeRepository->getClasses() as $class) {
            if ($class->isFinal()) {
                continue;
            }
            if ($class->isAbstract()) {
                continue;
            }
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
            if (!$phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class)) {
                continue;
            }
            /** @var EntityTagValueNode $entityTagValueNode */
            $entityTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
            if ($entityTagValueNode->getRepositoryClass() !== $repositoryClassName) {
                continue;
            }
            $className = $this->nodeNameResolver->getName($class);
            if (!\is_string($className)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \PHPStan\Type\ObjectType($className);
        }
        return null;
    }
}
