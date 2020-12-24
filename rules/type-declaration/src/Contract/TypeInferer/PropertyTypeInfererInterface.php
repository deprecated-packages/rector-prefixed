<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface PropertyTypeInfererInterface extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
