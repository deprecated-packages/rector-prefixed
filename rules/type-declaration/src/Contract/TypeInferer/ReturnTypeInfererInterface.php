<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ReturnTypeInfererInterface extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
