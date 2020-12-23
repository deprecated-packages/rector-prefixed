<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : bool;
}
