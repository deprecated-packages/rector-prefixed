<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareReturnTagValueNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
