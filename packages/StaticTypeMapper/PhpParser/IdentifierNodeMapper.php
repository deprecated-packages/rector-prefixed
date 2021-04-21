<?php

declare(strict_types=1);

namespace Rector\StaticTypeMapper\PhpParser;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;

final class IdentifierNodeMapper implements PhpParserNodeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;

    public function __construct(ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Identifier::class;
    }

    /**
     * @param Identifier $node
     */
    public function mapToPHPStan(Node $node): Type
    {
        return $this->scalarStringToTypeMapper->mapScalarStringToType($node->name);
    }
}
