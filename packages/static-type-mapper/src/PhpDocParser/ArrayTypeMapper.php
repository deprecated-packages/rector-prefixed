<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpDocParser;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper;
/**
 * @see \Rector\PHPStanStaticTypeMapper\Tests\TypeMapper\ArrayTypeMapperTest
 */
final class ArrayTypeMapper implements \Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var PhpDocTypeMapper
     */
    private $phpDocTypeMapper;
    public function getNodeType() : string
    {
        return \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode::class;
    }
    /**
     * @required
     */
    public function autowireArrayTypeMapper(\Rector\StaticTypeMapper\PhpDoc\PhpDocTypeMapper $phpDocTypeMapper) : void
    {
        $this->phpDocTypeMapper = $phpDocTypeMapper;
    }
    /**
     * @param ArrayTypeNode $typeNode
     */
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        $nestedType = $this->phpDocTypeMapper->mapToPHPStanType($typeNode->type, $node, $nameScope);
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $nestedType);
    }
}
