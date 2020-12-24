<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
final class CollectionTypeResolver
{
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory $nameScopeFactory)
    {
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function resolveFromTypeNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType
    {
        if ($typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            foreach ($typeNode->types as $unionedTypeNode) {
                $resolvedUnionedType = $this->resolveFromTypeNode($unionedTypeNode, $node);
                if ($resolvedUnionedType !== null) {
                    return $resolvedUnionedType;
                }
            }
        }
        if ($typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && $typeNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
            $fullyQualifiedName = $nameScope->resolveStringName($typeNode->type->name);
            return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
        }
        return null;
    }
    public function resolveFromOneToManyProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        /** @var OneToManyTagValueNode|null $oneToManyTagValueNode */
        $oneToManyTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class);
        if ($oneToManyTagValueNode === null) {
            return null;
        }
        $fullyQualifiedTargetEntity = $oneToManyTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
    }
}
