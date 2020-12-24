<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpParser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
final class NullableTypeNodeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    /**
     * @required
     */
    public function autowireNullableTypeNodeMapper(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper) : void
    {
        $this->phpParserNodeMapper = $phpParserNodeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType::class;
    }
    /**
     * @param NullableType $node
     */
    public function mapToPHPStan(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $types = [];
        $types[] = $this->phpParserNodeMapper->mapToPHPStanType($node->type);
        $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
