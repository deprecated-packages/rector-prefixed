<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface ParamTypeInfererInterface
{
    public function inferParam(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
