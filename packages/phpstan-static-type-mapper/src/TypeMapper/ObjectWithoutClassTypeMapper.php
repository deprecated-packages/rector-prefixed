<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ObjectWithoutClassTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType::class;
    }
    /**
     * @param ObjectWithoutClassType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('object');
    }
    /**
     * @param ObjectWithoutClassType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $subtractedType = $type->getSubtractedType();
        if ($subtractedType !== null) {
            return $this->phpStanStaticTypeMapper->mapToPhpParserNode($subtractedType);
        }
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::OBJECT_TYPE)) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Name('object');
    }
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
    }
    public function setPHPStanStaticTypeMapper(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
