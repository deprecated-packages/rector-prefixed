<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class StringTypeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isStringOrUnionStringOnlyType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        if ($nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
            return \true;
        }
        if ($nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            foreach ($nodeType->getTypes() as $singleType) {
                if ($singleType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\StringType())->no()) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
