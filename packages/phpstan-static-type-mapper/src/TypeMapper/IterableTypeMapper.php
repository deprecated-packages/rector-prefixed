<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use _PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class IterableTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @required
     */
    public function autowireIterableTypeMapper(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\IterableType::class;
    }
    /**
     * @param IterableType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getItemType());
        if ($itemTypeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes($itemTypeNode);
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
    }
    /**
     * @param IterableType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Name('iterable');
    }
    /**
     * @param IterableType $type
     */
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // iterable type is better done in PHP code, than in doc
            return '';
        }
        return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
    }
    private function convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $unionTypeNode) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode
    {
        $unionedArrayType = [];
        foreach ($unionTypeNode->types as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
                foreach ($unionedType->types as $key => $subUnionedType) {
                    $unionedType->types[$key] = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($subUnionedType);
                }
                $unionedArrayType[] = $unionedType;
                continue;
            }
            $unionedArrayType[] = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($unionedType);
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionedArrayType);
    }
}
