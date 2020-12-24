<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node
{
    public function setAttribute(string $name, $value) : void;
    public function getAttribute(string $name);
}
