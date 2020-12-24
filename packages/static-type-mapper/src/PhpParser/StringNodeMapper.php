<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class StringNodeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class;
    }
    /**
     * @param String_ $node
     */
    public function mapToPHPStan(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
    }
}
