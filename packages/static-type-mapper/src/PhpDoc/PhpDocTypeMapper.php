<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
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
    public function __construct(array $phpDocTypeMappers, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->phpDocTypeMappers = $phpDocTypeMappers;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function mapToPHPStanType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
