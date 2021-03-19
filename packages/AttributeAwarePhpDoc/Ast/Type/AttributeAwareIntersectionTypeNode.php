<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\Type;

use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
final class AttributeAwareIntersectionTypeNode extends \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode
{
    public function __toString() : string
    {
        return \implode('&', $this->types);
    }
}
