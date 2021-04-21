<?php

declare(strict_types=1);

namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;

final class TypeWithClassNameTypeMapper implements TypeMapperInterface
{
    /**
     * @var StringTypeMapper
     */
    private $stringTypeMapper;

    public function __construct(StringTypeMapper $stringTypeMapper)
    {
        $this->stringTypeMapper = $stringTypeMapper;
    }

    /**
     * @return class-string<Type>
     */
    public function getNodeClass(): string
    {
        return TypeWithClassName::class;
    }

    /**
     * @param TypeWithClassName $type
     */
    public function mapToPHPStanPhpDocTypeNode(Type $type): TypeNode
    {
        return new IdentifierTypeNode('string-class');
    }

    /**
     * @param TypeWithClassName $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode(Type $type, $kind = null)
    {
        return $this->stringTypeMapper->mapToPhpParserNode($type, $kind);
    }
}
