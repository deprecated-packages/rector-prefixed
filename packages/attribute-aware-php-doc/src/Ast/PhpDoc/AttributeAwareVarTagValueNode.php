<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareVarTagValueNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
}
