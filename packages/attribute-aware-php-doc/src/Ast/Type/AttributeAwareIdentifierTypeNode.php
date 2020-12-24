<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIdentifierTypeNode extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
}
