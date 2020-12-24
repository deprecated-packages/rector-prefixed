<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp70\Contract\Rector;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool;
}
