<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\Type;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class IntersectionTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @required
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     */
    public function autowireIntersectionTypeMapper($phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\IntersectionType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $intersectionTypesNodes = [];
        foreach ($type->getTypes() as $intersectionedType) {
            $intersectionTypesNodes[] = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($intersectionedType);
        }
        $intersectionTypesNodes = \array_unique($intersectionTypesNodes);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIntersectionTypeNode($intersectionTypesNodes);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     */
    public function mapToPhpParserNode($type, $kind = null) : ?\PhpParser\Node
    {
        // intersection types in PHP are not yet supported
        return null;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString($type, $parentType = null) : string
    {
        $stringTypes = [];
        foreach ($type->getTypes() as $unionedType) {
            $stringTypes[] = $this->phpStanStaticTypeMapper->mapToDocString($unionedType);
        }
        // remove empty values, e.g. void/iterable
        $stringTypes = \array_unique($stringTypes);
        $stringTypes = \array_filter($stringTypes);
        return \implode('&', $stringTypes);
    }
}
