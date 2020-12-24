<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
final class UnionTypeNodeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    /**
     * @required
     */
    public function autowireUnionTypeNodeMapper(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper) : void
    {
        $this->phpParserNodeMapper = $phpParserNodeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\UnionType::class;
    }
    /**
     * @param UnionType $node
     */
    public function mapToPHPStan(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        foreach ($node->types as $unionedType) {
            $types[] = $this->phpParserNodeMapper->mapToPHPStanType($unionedType);
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
