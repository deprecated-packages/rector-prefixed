<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
interface RenameParamValueObjectInterface extends \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getFunctionLike() : \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
    public function getParam() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Param;
}
