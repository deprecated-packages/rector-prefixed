<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
interface RenameParamValueObjectInterface extends \_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getFunctionLike() : \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
    public function getParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param;
}
