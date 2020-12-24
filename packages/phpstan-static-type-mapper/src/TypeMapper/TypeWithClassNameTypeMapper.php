<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class TypeWithClassNameTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var StringTypeMapper
     */
    private $stringTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper\StringTypeMapper $stringTypeMapper)
    {
        $this->stringTypeMapper = $stringTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName::class;
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('string-class');
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->stringTypeMapper->mapToPhpParserNode($type, $kind);
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
