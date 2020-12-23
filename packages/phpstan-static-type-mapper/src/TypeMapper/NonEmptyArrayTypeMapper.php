<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class NonEmptyArrayTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\NonEmptyArrayType::class;
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode(new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('mixed'));
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('array');
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToDocString(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $parentType = null) : string
    {
        return 'mixed[]';
    }
}
