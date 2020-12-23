<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
final class NullableTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireNullableTypeMapper(\_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param NullableTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $nestedType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode->type, $node, $nameScope);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType(), $nestedType]);
    }
}
