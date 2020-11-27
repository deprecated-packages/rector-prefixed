<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\ChildPopulator;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\UnionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStan\Type\SelfObjectType;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class ChildReturnPopulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * Add typehint to all children class methods
     */
    public function populateChildren(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Type $returnType) : void
    {
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if ($methodName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
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
        if ($currentClassMethod === null) {
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
    /**
     * @return Name|NullableType|UnionType|null
     */
    private function resolveChildTypeNode(\PHPStan\Type\Type $type) : ?\PhpParser\Node
    {
        if ($type instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        if ($type instanceof \Rector\PHPStan\Type\SelfObjectType || $type instanceof \PHPStan\Type\StaticType) {
            $type = new \PHPStan\Type\ObjectType($type->getClassName());
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
    }
}
