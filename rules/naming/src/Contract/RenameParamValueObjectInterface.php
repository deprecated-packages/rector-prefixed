<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
interface RenameParamValueObjectInterface extends \_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getFunctionLike() : \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
    public function getParam() : \_PhpScoper0a6b37af0871\PhpParser\Node\Param;
}
