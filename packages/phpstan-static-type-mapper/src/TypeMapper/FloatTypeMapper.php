<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class FloatTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType::class;
    }
    /**
     * @param FloatType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('float');
    }
    /**
     * @param FloatType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('float');
    }
    public function mapToDocString(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
