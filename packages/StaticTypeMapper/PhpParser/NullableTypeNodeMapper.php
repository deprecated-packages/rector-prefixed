<?php

declare(strict_types=1);

namespace Rector\StaticTypeMapper\PhpParser;

use PhpParser\Node;
use PhpParser\Node\NullableType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;

final class NullableTypeNodeMapper implements PhpParserNodeMapperInterface
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;

    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;

    public function __construct(TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }

    /**
     * @required
     * @return void
     */
    public function autowireNullableTypeNodeMapper(PhpParserNodeMapper $phpParserNodeMapper)
    {
        $this->phpParserNodeMapper = $phpParserNodeMapper;
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return NullableType::class;
    }

    /**
     * @param NullableType $node
     */
    public function mapToPHPStan(Node $node): Type
    {
        $types = [];
        $types[] = $this->phpParserNodeMapper->mapToPHPStanType($node->type);
        $types[] = new NullType();

        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
