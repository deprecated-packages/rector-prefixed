<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareThrowsTagValueNode extends \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode implements \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
