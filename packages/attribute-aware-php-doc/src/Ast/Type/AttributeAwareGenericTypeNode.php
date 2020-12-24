<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareGenericTypeNode extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
