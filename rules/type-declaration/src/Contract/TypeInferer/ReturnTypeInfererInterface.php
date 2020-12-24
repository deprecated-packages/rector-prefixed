<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface ReturnTypeInfererInterface extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferFunctionLike(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
