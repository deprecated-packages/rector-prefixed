<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Type\IterableType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class IterableTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @required
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     */
    public function autowireIterableTypeMapper($phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\IterableType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getItemType());
        if ($itemTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes($itemTypeNode);
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     */
    public function mapToPhpParserNode($type, $kind = null) : ?\PhpParser\Node
    {
        return new \PhpParser\Node\Name('iterable');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString($type, $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // iterable type is better done in PHP code, than in doc
            return '';
        }
        return $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
    }
    /**
     * @param \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $unionTypeNode
     */
    private function convertUnionArrayTypeNodesToArrayTypeOfUnionTypeNodes($unionTypeNode) : \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode
    {
        $unionedArrayType = [];
        foreach ($unionTypeNode->types as $unionedType) {
            if ($unionedType instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
                foreach ($unionedType->types as $key => $subUnionedType) {
                    $unionedType->types[$key] = new \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($subUnionedType);
                }
                $unionedArrayType[] = $unionedType;
                continue;
            }
            $unionedArrayType[] = new \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($unionedType);
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionedArrayType);
    }
}
