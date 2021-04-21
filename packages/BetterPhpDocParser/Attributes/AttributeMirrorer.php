<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\Attributes;

use PHPStan\PhpDocParser\Ast\Node;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;

final class AttributeMirrorer
{
    /**
     * @var string[]
     */
    const ATTRIBUTES_TO_MIRROR = [
        PhpDocAttributeKey::PARENT,
        PhpDocAttributeKey::START_AND_END,
        PhpDocAttributeKey::ORIG_NODE,
    ];

    /**
     * @return void
     */
    public function mirror(Node $oldNode, Node $newNode)
    {
        foreach (self::ATTRIBUTES_TO_MIRROR as $attributeToMirror) {
            if (! $oldNode->hasAttribute($attributeToMirror)) {
                continue;
            }

            $attributeValue = $oldNode->getAttribute($attributeToMirror);
            $newNode->setAttribute($attributeToMirror, $attributeValue);
        }
    }
}
