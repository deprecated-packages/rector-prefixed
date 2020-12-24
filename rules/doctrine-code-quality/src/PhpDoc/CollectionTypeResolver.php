<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
final class CollectionTypeResolver
{
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PHPStan\NameScopeFactory $nameScopeFactory)
    {
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function resolveFromTypeNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType
    {
        if ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            foreach ($typeNode->types as $unionedTypeNode) {
                $resolvedUnionedType = $this->resolveFromTypeNode($unionedTypeNode, $node);
                if ($resolvedUnionedType !== null) {
                    return $resolvedUnionedType;
                }
            }
        }
        if ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && $typeNode->type instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
            $fullyQualifiedName = $nameScope->resolveStringName($typeNode->type->name);
            return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
        }
        return null;
    }
    public function resolveFromOneToManyProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        /** @var OneToManyTagValueNode|null $oneToManyTagValueNode */
        $oneToManyTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class);
        if ($oneToManyTagValueNode === null) {
            return null;
        }
        $fullyQualifiedTargetEntity = $oneToManyTagValueNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
    }
}
