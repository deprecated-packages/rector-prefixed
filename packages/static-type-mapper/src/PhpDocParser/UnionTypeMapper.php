<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
final class UnionTypeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireUnionTypeMapper(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param UnionTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $unionedTypes = [];
        foreach ($typeNode->types as $unionedTypeNode) {
            $unionedTypes[] = $this->phpDocTypeMapper->mapToPHPStanType($unionedTypeNode, $node, $nameScope);
        }
        // to prevent missing class error, e.g. in tests
        return $this->typeFactory->createMixedPassedOrUnionType($unionedTypes);
    }
}
