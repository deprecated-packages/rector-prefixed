<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class VoidTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var string
     */
    private const VOID = 'void';
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\VoidType::class;
    }
    /**
     * @param VoidType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode(self::VOID);
    }
    /**
     * @param VoidType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::VOID_TYPE)) {
            return null;
        }
        if (\in_array($kind, ['param', 'property'], \true)) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Name(self::VOID);
    }
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // the void type is better done in PHP code
            return '';
        }
        // fallback for PHP 7.0 and older, where void type was only in docs
        return self::VOID;
    }
}
