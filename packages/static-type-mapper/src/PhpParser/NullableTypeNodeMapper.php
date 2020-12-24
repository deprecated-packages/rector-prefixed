<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
final class NullableTypeNodeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    /**
     * @required
     */
    public function autowireNullableTypeNodeMapper(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper) : void
    {
        $this->phpParserNodeMapper = $phpParserNodeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\NullableType::class;
    }
    /**
     * @param NullableType $node
     */
    public function mapToPHPStan(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $types = [];
        $types[] = $this->phpParserNodeMapper->mapToPHPStanType($node->type);
        $types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
