<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
/**
 * @see \Rector\StaticTypeMapper\Tests\PhpDoc\PhpDocTypeMapperTest
 */
final class PhpDocTypeMapper
{
    /**
     * @var PhpDocTypeMapperInterface[]
     */
    private $phpDocTypeMappers = [];
    /**
     * @var TypeNodeResolver
     */
    private $typeNodeResolver;
    /**
     * @param PhpDocTypeMapperInterface[] $phpDocTypeMappers
     */
    public function __construct(array $phpDocTypeMappers, \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->phpDocTypeMappers = $phpDocTypeMappers;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function mapToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
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
