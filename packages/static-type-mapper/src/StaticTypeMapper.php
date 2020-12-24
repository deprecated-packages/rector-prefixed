<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
/**
 * Maps PhpParser <=> PHPStan <=> PHPStan doc <=> string type nodes between all possible formats
 * @see \Rector\NodeTypeResolver\Tests\StaticTypeMapper\StaticTypeMapperTest
 */
final class StaticTypeMapper
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var PhpParserNodeMapper
     */
    private $phpParserNodeMapper;
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    /**
     * @var NameScopeFactory
     */
    private $nameScopeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PHPStan\NameScopeFactory $nameScopeFactory, \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
        $this->phpParserNodeMapper = $phpParserNodeMapper;
        $this->phpDocTypeMapper = $phpDocTypeMapper;
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function mapPHPStanTypeToPHPStanPhpDocTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpStanType) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($phpStanType);
    }
    /**
     * @return Name|NullableType|PhpParserUnionType|null
     */
    public function mapPHPStanTypeToPhpParserNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpStanType, ?string $kind = null) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->phpStanStaticTypeMapper->mapToPhpParserNode($phpStanType, $kind);
    }
    public function mapPHPStanTypeToDocString(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $phpStanType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $parentType = null) : string
    {
        return $this->phpStanStaticTypeMapper->mapToDocString($phpStanType, $parentType);
    }
    public function mapPhpParserNodePHPStanType(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->phpParserNodeMapper->mapToPHPStanType($node);
    }
    public function mapPHPStanPhpDocTypeToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($phpDocTagValueNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($phpDocTagValueNode));
    }
    public function mapPHPStanPhpDocTypeNodeToPhpDocString(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : string
    {
        $phpStanType = $this->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $node);
        return $this->mapPHPStanTypeToDocString($phpStanType);
    }
    public function mapPHPStanPhpDocTypeNodeToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
        return $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
    }
}
