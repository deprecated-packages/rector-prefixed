<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpDoc;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
/**
 * @see \Rector\Tests\StaticTypeMapper\PhpDoc\PhpDocTypeMapperTest
 */
final class PhpDocTypeMapper
{
    /**
     * @var mixed[]
     */
    private $phpDocTypeMappers;
    /**
     * @var \PHPStan\PhpDoc\TypeNodeResolver
     */
    private $typeNodeResolver;
    /**
     * @param PhpDocTypeMapperInterface[] $phpDocTypeMappers
     */
    public function __construct(
        /**
         * @var PhpDocTypeMapperInterface[]
         */
        array $phpDocTypeMappers,
        \PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver
    )
    {
        $this->phpDocTypeMappers = $phpDocTypeMappers;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        foreach ($this->phpDocTypeMappers as $phpDocTypeMapper) {
            if (!\is_a($typeNode, $phpDocTypeMapper->getNodeType())) {
                continue;
            }
            return $phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
        }
        // fallback to PHPStan resolver
        return $this->typeNodeResolver->resolve($typeNode, $nameScope);
    }
}
