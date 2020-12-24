<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
interface RenameParamValueObjectInterface extends \_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getFunctionLike() : \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
    public function getParam() : \_PhpScopere8e811afab72\PhpParser\Node\Param;
}
