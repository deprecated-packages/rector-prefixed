<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
interface DowngradeParamDeclarationRectorInterface
{
    /**
     * Indicate if the parameter must be removed
     */
    public function shouldRemoveParamDeclaration(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool;
}
