<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\ImplementsTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareImplementsTagValueNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\ImplementsTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
}
