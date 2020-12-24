<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class NonEmptyArrayTypeMapper implements \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType::class;
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode(new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('mixed'));
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPhpParserNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('array');
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToDocString(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $parentType = null) : string
    {
        return 'mixed[]';
    }
}
