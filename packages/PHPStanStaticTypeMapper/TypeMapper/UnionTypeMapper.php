<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PhpParser\NodeAbstract;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\IterableType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\PHPStanStaticTypeMapper\TypeAnalyzer\BoolUnionTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeCommonTypeNarrower;
use Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis;
final class UnionTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var UnionTypeAnalyzer
     */
    private $unionTypeAnalyzer;
    /**
     * @var DoctrineTypeAnalyzer
     */
    private $doctrineTypeAnalyzer;
    /**
     * @var BoolUnionTypeAnalyzer
     */
    private $boolUnionTypeAnalyzer;
    /**
     * @var UnionTypeCommonTypeNarrower
     */
    private $unionTypeCommonTypeNarrower;
    public function __construct(\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer $unionTypeAnalyzer, \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\BoolUnionTypeAnalyzer $boolUnionTypeAnalyzer, \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeCommonTypeNarrower $unionTypeCommonTypeNarrower)
    {
        $this->phpVersionProvider = $phpVersionProvider;
        $this->unionTypeAnalyzer = $unionTypeAnalyzer;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->boolUnionTypeAnalyzer = $boolUnionTypeAnalyzer;
        $this->unionTypeCommonTypeNarrower = $unionTypeCommonTypeNarrower;
    }
    /**
     * @required
     */
    public function autowireUnionTypeMapper(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\UnionType::class;
    }
    /**
     * @param UnionType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $unionTypesNodes = [];
        $skipIterable = $this->shouldSkipIterable($type);
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\IterableType && $skipIterable) {
                continue;
            }
            $unionTypesNodes[] = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($unionedType);
        }
        $unionTypesNodes = \array_unique($unionTypesNodes);
        return new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode($unionTypesNodes);
    }
    /**
     * @param UnionType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        $arrayNode = $this->matchArrayTypes($type);
        if ($arrayNode !== null) {
            return $arrayNode;
        }
        if ($this->boolUnionTypeAnalyzer->isNullableBoolUnionType($type) && !$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
            return new \PhpParser\Node\NullableType(new \PhpParser\Node\Name('bool'));
        }
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES) && $this->isFalseBoolUnion($type)) {
            // return new Bool
            return new \PhpParser\Node\Name('bool');
        }
        // special case for nullable
        $nullabledType = $this->matchTypeForNullableUnionType($type);
        if (!$nullabledType instanceof \PHPStan\Type\Type) {
            // use first unioned type in case of unioned object types
            return $this->matchTypeForUnionedObjectTypes($type);
        }
        // void cannot be nullable
        if ($nullabledType instanceof \PHPStan\Type\VoidType) {
            return null;
        }
        $nullabledTypeNode = $this->phpStanStaticTypeMapper->mapToPhpParserNode($nullabledType);
        if (!$nullabledTypeNode instanceof \PhpParser\Node) {
            return null;
        }
        if ($nullabledTypeNode instanceof \PhpParser\Node\NullableType) {
            return $nullabledTypeNode;
        }
        if ($nullabledTypeNode instanceof \PhpParser\Node\UnionType) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \PhpParser\Node\NullableType($nullabledTypeNode);
    }
    private function shouldSkipIterable(\PHPStan\Type\UnionType $unionType) : bool
    {
        $unionTypeAnalysis = $this->unionTypeAnalyzer->analyseForNullableAndIterable($unionType);
        if (!$unionTypeAnalysis instanceof \Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis) {
            return \false;
        }
        if (!$unionTypeAnalysis->hasIterable()) {
            return \false;
        }
        return $unionTypeAnalysis->hasArray();
    }
    /**
     * @return Name|NullableType|null
     */
    private function matchArrayTypes(\PHPStan\Type\UnionType $unionType) : ?\PhpParser\Node
    {
        $unionTypeAnalysis = $this->unionTypeAnalyzer->analyseForNullableAndIterable($unionType);
        if (!$unionTypeAnalysis instanceof \Rector\PHPStanStaticTypeMapper\ValueObject\UnionTypeAnalysis) {
            return null;
        }
        $type = $unionTypeAnalysis->hasIterable() ? 'iterable' : 'array';
        if ($unionTypeAnalysis->isNullableType()) {
            return new \PhpParser\Node\NullableType($type);
        }
        return new \PhpParser\Node\Name($type);
    }
    private function matchTypeForNullableUnionType(\PHPStan\Type\UnionType $unionType) : ?\PHPStan\Type\Type
    {
        if (\count($unionType->getTypes()) !== 2) {
            return null;
        }
        $firstType = $unionType->getTypes()[0];
        $secondType = $unionType->getTypes()[1];
        if ($firstType instanceof \PHPStan\Type\NullType) {
            return $secondType;
        }
        if ($secondType instanceof \PHPStan\Type\NullType) {
            return $firstType;
        }
        return null;
    }
    /**
     * @return Name|FullyQualified|PhpParserUnionType|null
     */
    private function matchTypeForUnionedObjectTypes(\PHPStan\Type\UnionType $unionType) : ?\PhpParser\Node
    {
        $phpParserUnionType = $this->matchPhpParserUnionType($unionType);
        if ($phpParserUnionType !== null) {
            if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
                // maybe all one type?
                if ($this->boolUnionTypeAnalyzer->isBoolUnionType($unionType)) {
                    return new \PhpParser\Node\Name('bool');
                }
                return null;
            }
            return $phpParserUnionType;
        }
        if ($this->boolUnionTypeAnalyzer->isBoolUnionType($unionType)) {
            return new \PhpParser\Node\Name('bool');
        }
        // the type should be compatible with all other types, e.g. A extends B, B
        $compatibleObjectType = $this->resolveCompatibleObjectCandidate($unionType);
        if (!$compatibleObjectType instanceof \PHPStan\Type\ObjectType) {
            return null;
        }
        return new \PhpParser\Node\Name\FullyQualified($compatibleObjectType->getClassName());
    }
    private function matchPhpParserUnionType(\PHPStan\Type\UnionType $unionType) : ?\PhpParser\Node\UnionType
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
            return null;
        }
        $phpParserUnionedTypes = [];
        foreach ($unionType->getTypes() as $unionedType) {
            // void type is not allowed in union
            if ($unionedType instanceof \PHPStan\Type\VoidType) {
                return null;
            }
            /** @var Identifier|Name|null $phpParserNode */
            $phpParserNode = $this->phpStanStaticTypeMapper->mapToPhpParserNode($unionedType);
            if ($phpParserNode === null) {
                return null;
            }
            $phpParserUnionedTypes[] = $phpParserNode;
        }
        return new \PhpParser\Node\UnionType($phpParserUnionedTypes);
    }
    private function resolveCompatibleObjectCandidate(\PHPStan\Type\UnionType $unionType) : ?\PHPStan\Type\TypeWithClassName
    {
        if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($unionType)) {
            return new \PHPStan\Type\ObjectType('Doctrine\\Common\\Collections\\Collection');
        }
        if (!$this->unionTypeAnalyzer->hasTypeClassNameOnly($unionType)) {
            return null;
        }
        $sharedTypeWithClassName = $this->matchTwoObjectTypes($unionType);
        if ($sharedTypeWithClassName instanceof \PHPStan\Type\TypeWithClassName) {
            return $this->correctObjectType($sharedTypeWithClassName);
        }
        // find least common denominator
        return $this->unionTypeCommonTypeNarrower->narrowToSharedObjectType($unionType);
    }
    private function matchTwoObjectTypes(\PHPStan\Type\UnionType $unionType) : ?\PHPStan\Type\TypeWithClassName
    {
        /** @var TypeWithClassName $unionedType */
        foreach ($unionType->getTypes() as $unionedType) {
            /** @var TypeWithClassName $nestedUnionedType */
            foreach ($unionType->getTypes() as $nestedUnionedType) {
                if (!$this->areTypeWithClassNamesRelated($unionedType, $nestedUnionedType)) {
                    continue 2;
                }
            }
            return $unionedType;
        }
        return null;
    }
    private function areTypeWithClassNamesRelated(\PHPStan\Type\TypeWithClassName $firstType, \PHPStan\Type\TypeWithClassName $secondType) : bool
    {
        if ($firstType->accepts($secondType, \false)->yes()) {
            return \true;
        }
        return $secondType->accepts($firstType, \false)->yes();
    }
    private function correctObjectType(\PHPStan\Type\TypeWithClassName $typeWithClassName) : \PHPStan\Type\TypeWithClassName
    {
        if ($typeWithClassName->getClassName() === \PhpParser\NodeAbstract::class) {
            return new \PHPStan\Type\ObjectType('PhpParser\\Node');
        }
        if ($typeWithClassName->getClassName() === \Rector\Core\Rector\AbstractRector::class) {
            return new \PHPStan\Type\ObjectType('Rector\\Core\\Contract\\Rector\\RectorInterface');
        }
        return $typeWithClassName;
    }
    private function isFalseBoolUnion(\PHPStan\Type\UnionType $unionType) : bool
    {
        if (\count($unionType->getTypes()) !== 2) {
            return \false;
        }
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
