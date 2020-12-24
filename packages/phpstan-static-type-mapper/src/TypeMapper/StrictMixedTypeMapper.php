<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\StrictMixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class StrictMixedTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var string
     */
    private const MIXED = 'mixed';
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\StrictMixedType::class;
    }
    /**
     * @param StrictMixedType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode(self::MIXED);
    }
    /**
     * @param StrictMixedType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Name(self::MIXED);
    }
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        return self::MIXED;
    }
}
