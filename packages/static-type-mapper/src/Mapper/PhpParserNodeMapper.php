<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
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
    public function mapToPHPStanType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        foreach ($this->phpParserNodeMappers as $phpParserNodeMapper) {
            if (!\is_a($node, $phpParserNodeMapper->getNodeType())) {
                continue;
            }
            // do not let Expr collect all the types
            // note: can be solve later with priorities on mapper interface, making this last
            if ($phpParserNodeMapper->getNodeType() === \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class && \is_a($node, \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_::class)) {
                continue;
            }
            return $phpParserNodeMapper->mapToPHPStan($node);
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException(\get_class($node));
    }
}
