<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareThrowsTagValueNode extends \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
