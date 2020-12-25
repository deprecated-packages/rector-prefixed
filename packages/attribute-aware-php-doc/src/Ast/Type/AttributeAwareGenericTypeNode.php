<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\Type;

use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareGenericTypeNode extends \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
