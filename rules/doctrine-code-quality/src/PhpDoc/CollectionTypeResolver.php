<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\Naming\NameScopeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class CollectionTypeResolver
{
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\Naming\NameScopeFactory $nameScopeFactory)
    {
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function resolveFromTypeNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType
    {
        if ($typeNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            foreach ($typeNode->types as $unionedTypeNode) {
                $resolvedUnionedType = $this->resolveFromTypeNode($unionedTypeNode, $node);
                if ($resolvedUnionedType !== null) {
                    return $resolvedUnionedType;
                }
            }
        }
        if ($typeNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && $typeNode->type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
            $fullyQualifiedName = $nameScope->resolveStringName($typeNode->type->name);
            return new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedName);
        }
        return null;
    }
    public function resolveFromOneToManyProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        /** @var OneToManyTagValueNode|null $oneToManyTagValueNode */
        $oneToManyTagValueNode = $phpDocInfo->getByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class);
        if ($oneToManyTagValueNode === null) {
            return null;
        }
        $fullyQualifiedTargetEntity = $oneToManyTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
    }
}
