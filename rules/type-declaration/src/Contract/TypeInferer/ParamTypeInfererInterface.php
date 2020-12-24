<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ParamTypeInfererInterface
{
    public function inferParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
