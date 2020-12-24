<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
final class UnionTypeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireUnionTypeMapper(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param UnionTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $unionedTypes = [];
        foreach ($typeNode->types as $unionedTypeNode) {
            $unionedTypes[] = $this->phpDocTypeMapper->mapToPHPStanType($unionedTypeNode, $node, $nameScope);
        }
        // to prevent missing class error, e.g. in tests
        return $this->typeFactory->createMixedPassedOrUnionType($unionedTypes);
    }
}
