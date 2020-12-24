<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
use _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
final class SelfObjectTypeMapper implements \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType::class;
    }
    /**
     * @param SelfObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('self');
    }
    /**
     * @param SelfObjectType $type
     */
    public function mapToPhpParserNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('self');
    }
    /**
     * @param SelfObjectType $type
     */
    public function mapToDocString(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
