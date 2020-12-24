<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer;
final class UnionTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer $unionTypeAnalyzer)
    {
        $this->phpVersionProvider = $phpVersionProvider;
        $this->unionTypeAnalyzer = $unionTypeAnalyzer;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
    }
    /**
     * @required
     */
    public function autowireUnionTypeMapper(\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType::class;
    }
    /**
     * @param UnionType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $unionTypesNodes = [];
        $skipIterable = $this->shouldSkipIterable($type);
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType && $skipIterable) {
                continue;
            }
            $unionTypesNodes[] = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($unionedType);
        }
        $unionTypesNodes = \array_unique($unionTypesNodes);
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionTypesNodes);
    }
    /**
     * @param UnionType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $arrayNode = $this->matchArrayTypes($type);
        if ($arrayNode !== null) {
            return $arrayNode;
        }
        // special case for nullable
        $nullabledType = $this->matchTypeForNullableUnionType($type);
        if ($nullabledType === null) {
            // use first unioned type in case of unioned object types
            return $this->matchTypeForUnionedObjectTypes($type);
        }
        // void cannot be nullable
        if ($nullabledType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType) {
            return null;
        }
        $nullabledTypeNode = $this->phpStanStaticTypeMapper->mapToPhpParserNode($nullabledType);
        if ($nullabledTypeNode === null) {
            return null;
        }
        if ($nullabledTypeNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            return $nullabledTypeNode;
        }
        if ($nullabledTypeNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\UnionType) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType($nullabledTypeNode);
    }
    /**
     * @param UnionType $type
     */
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        $docStrings = [];
        foreach ($type->getTypes() as $unionedType) {
            $docStrings[] = $this->phpStanStaticTypeMapper->mapToDocString($unionedType);
        }
        // remove empty values, e.g. void/iterable
        $docStrings = \array_unique($docStrings);
        $docStrings = \array_filter($docStrings);
        return \implode('|', $docStrings);
    }
    private function shouldSkipIterable(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : bool
    {
        $unionTypeAnalysis = $this->unionTypeAnalyzer->analyseForNullableAndIterable($unionType);
        if ($unionTypeAnalysis === null) {
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
    private function matchArrayTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $unionTypeAnalysis = $this->unionTypeAnalyzer->analyseForNullableAndIterable($unionType);
        if ($unionTypeAnalysis === null) {
            return null;
        }
        $type = $unionTypeAnalysis->hasIterable() ? 'iterable' : 'array';
        if ($unionTypeAnalysis->isNullableType()) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType($type);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($type);
    }
    private function matchTypeForNullableUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($unionType->getTypes()) !== 2) {
            return null;
        }
        $firstType = $unionType->getTypes()[0];
        $secondType = $unionType->getTypes()[1];
        if ($firstType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return $secondType;
        }
        if ($secondType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return $firstType;
        }
        return null;
    }
    /**
     * @return Name|FullyQualified|PhpParserUnionType|null
     */
    private function matchTypeForUnionedObjectTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $phpParserUnionType = $this->matchPhpParserUnionType($unionType);
        if ($phpParserUnionType !== null) {
            if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
                return null;
            }
            return $phpParserUnionType;
        }
        // the type should be compatible with all other types, e.g. A extends B, B
        $compatibleObjectCandidate = $this->resolveCompatibleObjectCandidate($unionType);
        if ($compatibleObjectCandidate === null) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($compatibleObjectCandidate);
    }
    private function matchPhpParserUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\UnionType
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES)) {
            return null;
        }
        $phpParserUnionedTypes = [];
        foreach ($unionType->getTypes() as $unionedType) {
            // void type is not allowed in union
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType) {
                return null;
            }
            /** @var Identifier|Name|null $phpParserNode */
            $phpParserNode = $this->phpStanStaticTypeMapper->mapToPhpParserNode($unionedType);
            if ($phpParserNode === null) {
                return null;
            }
            $phpParserUnionedTypes[] = $phpParserNode;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\UnionType($phpParserUnionedTypes);
    }
    private function resolveCompatibleObjectCandidate(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : ?string
    {
        if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($unionType)) {
            return '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Collections\\Collection';
        }
        if (!$this->isUnionTypeWithTypeClassNameOnly($unionType)) {
            return null;
        }
        /** @var TypeWithClassName $unionedType */
        foreach ($unionType->getTypes() as $unionedType) {
            /** @var TypeWithClassName $nestedUnionedType */
            foreach ($unionType->getTypes() as $nestedUnionedType) {
                if (!$this->areTypeWithClassNamesRelated($unionedType, $nestedUnionedType)) {
                    continue 2;
                }
            }
            return $unionedType->getClassName();
        }
        return null;
    }
    private function isUnionTypeWithTypeClassNameOnly(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : bool
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
        }
        return \true;
    }
    private function areTypeWithClassNamesRelated(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $firstType, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $secondType) : bool
    {
        if (\is_a($firstType->getClassName(), $secondType->getClassName(), \true)) {
            return \true;
        }
        return \is_a($secondType->getClassName(), $firstType->getClassName(), \true);
    }
}
