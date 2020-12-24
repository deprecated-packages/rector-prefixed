<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ParamTypeInfererInterface
{
    public function inferParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
