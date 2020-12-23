<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
final class UnionTypeNodeMapper implements \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    /**
     * @required
     */
    public function autowireUnionTypeNodeMapper(\_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper) : void
    {
        $this->phpParserNodeMapper = $phpParserNodeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\UnionType::class;
    }
    /**
     * @param UnionType $node
     */
    public function mapToPHPStan(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $types = [];
        foreach ($node->types as $unionedType) {
            $types[] = $this->phpParserNodeMapper->mapToPHPStanType($unionedType);
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
