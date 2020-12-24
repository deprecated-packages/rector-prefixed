<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
final class UnionTypeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireUnionTypeMapper(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param UnionTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $unionedTypes = [];
        foreach ($typeNode->types as $unionedTypeNode) {
            $unionedTypes[] = $this->phpDocTypeMapper->mapToPHPStanType($unionedTypeNode, $node, $nameScope);
        }
        // to prevent missing class error, e.g. in tests
        return $this->typeFactory->createMixedPassedOrUnionType($unionedTypes);
    }
}
