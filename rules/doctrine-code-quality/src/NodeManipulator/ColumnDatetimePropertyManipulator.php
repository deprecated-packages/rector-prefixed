<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
final class ColumnDatetimePropertyManipulator
{
    public function removeDefaultOption(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode $columnTagValueNode) : void
    {
        $options = $columnTagValueNode->getOptions();
        unset($options['default']);
        $columnTagValueNode->changeItem('options', $options);
    }
}
