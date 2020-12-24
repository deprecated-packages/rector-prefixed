<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : bool;
}
