<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class IterableTypeMapper implements \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @required
     */
    public function autowireIterableTypeMapper(\_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType::class;
    }
    /**
     * @param IterableType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getItemType());
        if ($itemTypeNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes($itemTypeNode);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
    }
    /**
     * @param IterableType $type
     */
    public function mapToPhpParserNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('iterable');
    }
    /**
     * @param IterableType $type
     */
    public function mapToDocString(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // iterable type is better done in PHP code, than in doc
            return '';
        }
        return $type->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly());
    }
    private function convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $unionTypeNode) : \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode
    {
        $unionedArrayType = [];
        foreach ($unionTypeNode->types as $unionedType) {
            if ($unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
                foreach ($unionedType->types as $key => $subUnionedType) {
                    $unionedType->types[$key] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($subUnionedType);
                }
                $unionedArrayType[] = $unionedType;
                continue;
            }
            $unionedArrayType[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($unionedType);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionedArrayType);
    }
}
