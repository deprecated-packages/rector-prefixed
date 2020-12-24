<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class PhpParserNodeMapper
{
    /**
     * @var PhpParserNodeMapperInterface[]
     */
    private $phpParserNodeMappers = [];
    /**
     * @param PhpParserNodeMapperInterface[] $phpParserNodeMappers
     */
    public function __construct(array $phpParserNodeMappers)
    {
        $this->phpParserNodeMappers = $phpParserNodeMappers;
    }
    public function mapToPHPStanType(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        foreach ($this->phpParserNodeMappers as $phpParserNodeMapper) {
            if (!\is_a($node, $phpParserNodeMapper->getNodeType())) {
                continue;
            }
            // do not let Expr collect all the types
            // note: can be solve later with priorities on mapper interface, making this last
            if ($phpParserNodeMapper->getNodeType() === \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class && \is_a($node, \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_::class)) {
                continue;
            }
            return $phpParserNodeMapper->mapToPHPStan($node);
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException(\get_class($node));
    }
}
