<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : bool;
}
