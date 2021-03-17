<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Contract\TypeInferer;

use PhpParser\Node\Stmt\Property;
use PHPStan\Type\Type;
interface PropertyTypeInfererInterface extends \Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface
{
    /**
     * @param \PhpParser\Node\Stmt\Property $property
     */
    public function inferProperty($property) : \PHPStan\Type\Type;
}
