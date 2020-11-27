<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpDoc;

use PhpParser\Node;
use PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Rector\Core\Exception\NotImplementedException;
use Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
final class PhpDocTypeMapper
{
    /**
     * @var PhpDocTypeMapperInterface[]
     */
    private $phpDocTypeMappers = [];
    /**
     * @param PhpDocTypeMapperInterface[] $phpDocTypeMappers
     */
    public function __construct(array $phpDocTypeMappers)
    {
        $this->phpDocTypeMappers = $phpDocTypeMappers;
    }
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type
    {
        foreach ($this->phpDocTypeMappers as $phpDocTypeMapper) {
            if (!\is_a($typeNode, $phpDocTypeMapper->getNodeType())) {
                continue;
            }
            return $phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
        }
        throw new \Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($typeNode));
    }
}
