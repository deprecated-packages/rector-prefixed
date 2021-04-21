<?php

declare(strict_types=1);

namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\StrictMixedType;
use PHPStan\Type\Type;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;

final class StrictMixedTypeMapper implements TypeMapperInterface
{
    /**
     * @var string
     */
    const MIXED = 'mixed';

    /**
     * @return class-string<Type>
     */
    public function getNodeClass(): string
    {
        return StrictMixedType::class;
    }

    /**
     * @param StrictMixedType $type
     */
    public function mapToPHPStanPhpDocTypeNode(Type $type): TypeNode
    {
        return new IdentifierTypeNode(self::MIXED);
    }

    /**
     * @param StrictMixedType $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode(Type $type, $kind = null)
    {
        return new Name(self::MIXED);
    }
}
