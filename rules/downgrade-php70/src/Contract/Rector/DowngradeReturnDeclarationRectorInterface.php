<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Contract\Rector;

use PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\PhpParser\Node\FunctionLike $functionLike) : bool;
}
