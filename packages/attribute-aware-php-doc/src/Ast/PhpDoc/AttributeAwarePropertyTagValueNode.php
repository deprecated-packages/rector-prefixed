<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwarePropertyTagValueNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
