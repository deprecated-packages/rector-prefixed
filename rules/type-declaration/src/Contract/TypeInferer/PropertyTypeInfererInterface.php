<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface PropertyTypeInfererInterface extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    public function inferProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
