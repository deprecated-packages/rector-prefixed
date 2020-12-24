<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ParamTypeInfererInterface
{
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
