<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class RequiredTagValueNode implements \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
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
        return '_PhpScoper0a2ac50786fa\\Symfony\\Contracts\\Service\\Attribute\\Required';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return [];
    }
}
