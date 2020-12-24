<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class MixedTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\MixedType::class;
    }
    /**
     * @param MixedType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('mixed');
    }
    /**
     * @param MixedType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return null;
    }
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
