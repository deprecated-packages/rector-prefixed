<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareInvalidTagValueNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
}
