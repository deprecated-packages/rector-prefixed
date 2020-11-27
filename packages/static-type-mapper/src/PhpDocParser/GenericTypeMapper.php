<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpDocParser;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
final class GenericTypeMapper implements \Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var TypeNodeResolver
     */
    private $typeNodeResolver;
    public function __construct(\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getNodeType() : string
    {
        return \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode::class;
    }
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        return $this->typeNodeResolver->resolve($typeNode, $nameScope);
    }
}
