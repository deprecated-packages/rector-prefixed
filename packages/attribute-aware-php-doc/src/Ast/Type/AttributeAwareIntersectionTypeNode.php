<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareIntersectionTypeNode extends \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    public function __toString() : string
    {
        return \implode('&', $this->types);
    }
}
