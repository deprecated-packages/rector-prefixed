<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
final class AttributeAwarePhpDocNode extends \_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var PhpDocChildNode[]|AttributeAwareNodeInterface[]
     */
    public $children = [];
    public function __toString() : string
    {
        return "/**\n * " . \implode("\n * ", $this->children) . "\n */";
    }
}
