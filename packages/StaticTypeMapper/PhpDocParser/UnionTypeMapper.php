<?php

declare(strict_types=1);

namespace Rector\StaticTypeMapper\PhpDocParser;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;

final class UnionTypeMapper implements PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;

    /**
     * @var TypeFactory
     */
    private $typeFactory;

    public function __construct(TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }

    /**
     * @return class-string<TypeNode>
     */
    public function getNodeType(): string
    {
        return UnionTypeNode::class;
    }

    /**
     * @required
     * @return void
     */
    public function autowireUnionTypeMapper(PhpDocTypeMapper $phpDocTypeMapper)
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }

    /**
     * @param UnionTypeNode $typeNode
     */
    public function mapToPHPStanType(TypeNode $typeNode, Node $node, NameScope $nameScope): Type
    {
        $unionedTypes = [];
        foreach ($typeNode->types as $unionedTypeNode) {
            $unionedTypes[] = $this->phpDocTypeMapper->mapToPHPStanType($unionedTypeNode, $node, $nameScope);
        }

        // to prevent missing class error, e.g. in tests
        return $this->typeFactory->createMixedPassedOrUnionTypeAndKeepConstant($unionedTypes);
    }
}
