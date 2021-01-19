<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\PhpDoc;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\StaticTypeMapper\Naming\NameScopeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class CollectionTypeResolver
{
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\StaticTypeMapper\Naming\NameScopeFactory $nameScopeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->nameScopeFactory = $nameScopeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function resolveFromTypeNode(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node) : ?\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType
    {
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            foreach ($typeNode->types as $unionedTypeNode) {
                $resolvedUnionedType = $this->resolveFromTypeNode($unionedTypeNode, $node);
                if ($resolvedUnionedType !== null) {
                    return $resolvedUnionedType;
                }
            }
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && $typeNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
            $fullyQualifiedName = $nameScope->resolveStringName($typeNode->type->name);
            return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedName);
        }
        return null;
    }
    public function resolveFromOneToManyProperty(\PhpParser\Node\Stmt\Property $property) : ?\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $oneToManyTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class);
        if (!$oneToManyTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode) {
            return null;
        }
        $fullyQualifiedTargetEntity = $oneToManyTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
    }
}
