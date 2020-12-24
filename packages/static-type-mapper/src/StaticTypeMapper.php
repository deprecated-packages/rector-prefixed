<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\PHPStan\NameScopeFactory $nameScopeFactory, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\PhpParserNodeMapper $phpParserNodeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
        $this->phpParserNodeMapper = $phpParserNodeMapper;
        $this->phpDocTypeMapper = $phpDocTypeMapper;
        $this->nameScopeFactory = $nameScopeFactory;
    }
    public function mapPHPStanTypeToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $phpStanType) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($phpStanType);
    }
    /**
     * @return Name|NullableType|PhpParserUnionType|null
     */
    public function mapPHPStanTypeToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $phpStanType, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->phpStanStaticTypeMapper->mapToPhpParserNode($phpStanType, $kind);
    }
    public function mapPHPStanTypeToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $phpStanType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        return $this->phpStanStaticTypeMapper->mapToDocString($phpStanType, $parentType);
    }
    public function mapPhpParserNodePHPStanType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->phpParserNodeMapper->mapToPHPStanType($node);
    }
    public function mapPHPStanPhpDocTypeToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode, \_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode) {
            return $this->mapPHPStanPhpDocTypeNodeToPHPStanType($phpDocTagValueNode->type, $node);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($phpDocTagValueNode));
    }
    public function mapPHPStanPhpDocTypeNodeToPhpDocString(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        $phpStanType = $this->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $node);
        return $this->mapPHPStanTypeToDocString($phpStanType);
    }
    public function mapPHPStanPhpDocTypeNodeToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $nameScope = $this->nameScopeFactory->createNameScopeFromNode($node);
        return $this->phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
    }
}
