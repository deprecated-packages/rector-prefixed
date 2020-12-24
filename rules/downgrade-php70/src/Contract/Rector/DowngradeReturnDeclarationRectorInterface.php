<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Contract\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
interface DowngradeReturnDeclarationRectorInterface
{
    public function shouldRemoveReturnDeclaration(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool;
}
