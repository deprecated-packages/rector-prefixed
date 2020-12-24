<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ThisType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareThisTypeNode;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
/**
 * @see \Rector\NodeTypeResolver\Tests\StaticTypeMapper\StaticTypeMapperTest
 */
final class StaticTypeMapper implements \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType::class;
    }
    /**
     * @param StaticType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareThisTypeNode();
    }
    /**
     * @param StaticType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ThisType) {
            // @todo wait for PHPStan to differentiate between self/static
            if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::STATIC_RETURN_TYPE)) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('static');
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('self');
        }
        return null;
    }
    /**
     * @param StaticType $type
     */
    public function mapToDocString(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
