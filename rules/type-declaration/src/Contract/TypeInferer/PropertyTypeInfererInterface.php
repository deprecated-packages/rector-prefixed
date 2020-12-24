<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface PropertyTypeInfererInterface extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
