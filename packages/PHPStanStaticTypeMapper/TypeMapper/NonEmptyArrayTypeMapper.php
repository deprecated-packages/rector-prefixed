<?php

declare(strict_types=1);

namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;

final class NonEmptyArrayTypeMapper implements TypeMapperInterface
{
    /**
     * @return class-string<Type>
     */
    public function getNodeClass(): string
    {
        return NonEmptyArrayType::class;
    }

    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPHPStanPhpDocTypeNode(Type $type): TypeNode
    {
        return new SpacingAwareArrayTypeNode(new IdentifierTypeNode('mixed'));
    }

    /**
     * @param NonEmptyArrayType $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode(Type $type, $kind = null)
    {
        return new Name('array');
    }
}
