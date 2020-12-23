<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface PropertyTypeInfererInterface extends \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
