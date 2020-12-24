<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
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
    public function mapToPHPStanType(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        foreach ($this->phpParserNodeMappers as $phpParserNodeMapper) {
            if (!\is_a($node, $phpParserNodeMapper->getNodeType())) {
                continue;
            }
            // do not let Expr collect all the types
            // note: can be solve later with priorities on mapper interface, making this last
            if ($phpParserNodeMapper->getNodeType() === \_PhpScopere8e811afab72\PhpParser\Node\Expr::class && \is_a($node, \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class)) {
                continue;
            }
            return $phpParserNodeMapper->mapToPHPStan($node);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(\get_class($node));
    }
}
