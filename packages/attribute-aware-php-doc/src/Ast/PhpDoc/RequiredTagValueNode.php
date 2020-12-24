<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class RequiredTagValueNode implements \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
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
        return '_PhpScoper2a4e7ab1ecbc\\Symfony\\Contracts\\Service\\Attribute\\Required';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return [];
    }
}
