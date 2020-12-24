<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class IterableTypeMapper implements \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @required
     */
    public function autowireIterableTypeMapper(\_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType::class;
    }
    /**
     * @param IterableType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getItemType());
        if ($itemTypeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes($itemTypeNode);
        }
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
    }
    /**
     * @param IterableType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('iterable');
    }
    /**
     * @param IterableType $type
     */
    public function mapToDocString(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // iterable type is better done in PHP code, than in doc
            return '';
        }
        return $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly());
    }
    private function convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $unionTypeNode) : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode
    {
        $unionedArrayType = [];
        foreach ($unionTypeNode->types as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
                foreach ($unionedType->types as $key => $subUnionedType) {
                    $unionedType->types[$key] = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($subUnionedType);
                }
                $unionedArrayType[] = $unionedType;
                continue;
            }
            $unionedArrayType[] = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($unionedType);
        }
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionedArrayType);
    }
}
