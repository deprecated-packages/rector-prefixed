<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
/**
 * @see \Rector\PHPStanStaticTypeMapper\Tests\TypeMapper\ArrayTypeMapperTest
 */
final class ArrayTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireArrayTypeMapper(\_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param ArrayTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $nestedType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode->type, $node, $nameScope);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), $nestedType);
    }
}
