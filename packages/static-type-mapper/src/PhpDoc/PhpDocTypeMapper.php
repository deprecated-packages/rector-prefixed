<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDoc;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
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
    public function mapToPHPStanType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        foreach ($this->phpDocTypeMappers as $phpDocTypeMapper) {
            if (!\is_a($typeNode, $phpDocTypeMapper->getNodeType())) {
                continue;
            }
            return $phpDocTypeMapper->mapToPHPStanType($typeNode, $node, $nameScope);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($typeNode));
    }
}
