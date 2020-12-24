<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ReturnTypeInfererInterface extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferFunctionLike(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
