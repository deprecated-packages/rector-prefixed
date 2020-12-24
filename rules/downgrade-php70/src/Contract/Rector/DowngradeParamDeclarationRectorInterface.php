<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
interface DowngradeParamDeclarationRectorInterface
{
    /**
     * Indicate if the parameter must be removed
     */
    public function shouldRemoveParamDeclaration(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : bool;
}
