<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
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
    public function __construct(array $phpDocTypeMappers, \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->phpDocTypeMappers = $phpDocTypeMappers;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function mapToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
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
