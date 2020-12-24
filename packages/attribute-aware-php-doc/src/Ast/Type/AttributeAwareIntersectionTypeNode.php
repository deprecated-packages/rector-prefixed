<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIntersectionTypeNode extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    public function __toString() : string
    {
        return \implode('&', $this->types);
    }
}
