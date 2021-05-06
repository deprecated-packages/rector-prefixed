<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpParser;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;
final class IdentifierNodeMapper implements \Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;
    public function __construct(\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
    }
    /**
     * @return class-string<Node>
     */
    public function getNodeType() : string
    {
        return \PhpParser\Node\Identifier::class;
    }
    /**
     * @param Identifier $node
     */
    public function mapToPHPStan(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->scalarStringToTypeMapper->mapScalarStringToType($node->name);
    }
}
