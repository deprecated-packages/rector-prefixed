<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface ParamTypeInfererInterface
{
    public function inferParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
