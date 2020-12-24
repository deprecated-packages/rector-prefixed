<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\StrictMixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class StrictMixedTypeMapper implements \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var string
     */
    private const MIXED = 'mixed';
    public function getNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\StrictMixedType::class;
    }
    /**
     * @param StrictMixedType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode(self::MIXED);
    }
    /**
     * @param StrictMixedType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name(self::MIXED);
    }
    public function mapToDocString(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $parentType = null) : string
    {
        return self::MIXED;
    }
}
