<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode;
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
     */
    public function autowireIntersectionTypeMapper(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
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
     * @param IntersectionType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $intersectionTypesNodes = [];
        foreach ($type->getTypes() as $intersectionedType) {
            $intersectionTypesNodes[] = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($intersectionedType);
        }
        $intersectionTypesNodes = \array_unique($intersectionTypesNodes);
        return new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode($intersectionTypesNodes);
    }
    /**
     * @param IntersectionType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        // intersection types in PHP are not yet supported
        return null;
    }
    /**
     * @param IntersectionType $type
     */
    public function mapToDocString(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $parentType = null) : string
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
