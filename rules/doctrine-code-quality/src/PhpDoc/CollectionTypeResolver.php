<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\PhpDoc;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStan\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
final class CollectionTypeResolver
{
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    public function __construct(\Rector\StaticTypeMapper\PHPStan\NameScopeFactory $nameScopeFactory)
    {
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function resolveFromTypeNode(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node) : ?\Rector\PHPStan\Type\FullyQualifiedObjectType
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
            return new \Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
        }
        return null;
    }
    public function resolveFromOneToManyProperty(\PhpParser\Node\Stmt\Property $property) : ?\Rector\PHPStan\Type\FullyQualifiedObjectType
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        /** @var OneToManyTagValueNode|null $oneToManyTagValueNode */
        $oneToManyTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class);
        if ($oneToManyTagValueNode === null) {
            return null;
        }
        $fullyQualifiedTargetEntity = $oneToManyTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
    }
}
