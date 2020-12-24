<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ReturnTypeInfererInterface extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferFunctionLike(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
