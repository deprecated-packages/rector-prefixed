<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
interface RenameParamValueObjectInterface extends \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getFunctionLike() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
    public function getParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
}
