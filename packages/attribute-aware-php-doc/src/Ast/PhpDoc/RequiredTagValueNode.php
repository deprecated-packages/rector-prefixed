<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class RequiredTagValueNode implements \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode, \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    use AttributeTrait;
    public function __toString() : string
    {
        return '';
    }
    public function getShortName() : string
    {
        return 'Required';
    }
    public function getAttributeClassName() : string
    {
        return '_PhpScoper567b66d83109\\Symfony\\Contracts\\Service\\Attribute\\Required';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return [];
    }
}
