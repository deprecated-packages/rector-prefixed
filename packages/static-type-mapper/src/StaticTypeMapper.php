<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Rector\Core\Exception\NotImplementedException;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
use Rector\StaticTypeMapper\Naming\NameScopeFactory;
use Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
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
    public function __construct(\Rector\StaticTypeMapper\Naming\NameScopeFactory $nameScopeFactory, \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper, \Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper, \Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
        $this->phpParserNodeMapper = $phpParserNodeMapper;
        $this->phpDocTypeMapper = $phpDocTypeMapper;
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function mapPHPStanTypeToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $phpStanType) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($phpStanType);
    }
    /**
     * @return Name|NullableType|PhpParserUnionType|null
     */
    public function mapPHPStanTypeToPhpParserNode(\PHPStan\Type\Type $phpStanType, ?string $kind = null) : ?\PhpParser\Node
    {
        return $this->phpStanStaticTypeMapper->mapToPhpParserNode($phpStanType, $kind);
    }
    public function mapPHPStanTypeToDocString(\PHPStan\Type\Type $phpStanType, ?\PHPStan\Type\Type $parentType = null) : string
    {
        return $this->phpStanStaticTypeMapper->mapToDocString($phpStanType, $parentType);
    }
    public function mapPhpParserNodePHPStanType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->phpParserNodeMapper->mapToPHPStanType($node);
    }
    public function mapPHPStanPhpDocTypeToPHPStanType(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode, \PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        if ($phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        if ($phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        if ($phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        throw new \Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($phpDocTagValueNode));
    }
    public function mapPHPStanPhpDocTypeNodeToPhpDocString(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node) : string
    {
        $phpStanType = $this->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $node);
        return $this->mapPHPStanTypeToDocString($phpStanType);
    }
    public function mapPHPStanPhpDocTypeNodeToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
        return $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
    }
}
