<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeManipulator;

use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode;
final class DoctrineItemDefaultValueManipulator
{
    /**
     * @param string|bool|int $defaultValue
     */
    public function remove(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode $doctrineTagValueNode, string $item, $defaultValue) : void
    {
        if (!$this->hasItemWithDefaultValue($doctrineTagValueNode, $item, $defaultValue)) {
            return;
        }
        $doctrineTagValueNode->removeItem($item);
        $phpDocInfo->markAsChanged();
    }
    /**
     * @param string|bool|int $defaultValue
     */
    private function hasItemWithDefaultValue(\Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode $doctrineTagValueNode, string $item, $defaultValue) : bool
    {
        $items = $doctrineTagValueNode->getItems();
        if (!isset($items[$item])) {
            return \false;
        }
        return $items[$item] === $defaultValue;
    }
}
