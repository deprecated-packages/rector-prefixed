<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
final class ColumnDatetimePropertyManipulator
{
    public function removeDefaultOption(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode $columnTagValueNode) : void
    {
        $options = $columnTagValueNode->getOptions();
        unset($options['default']);
        $columnTagValueNode->changeItem('options', $options);
    }
}
