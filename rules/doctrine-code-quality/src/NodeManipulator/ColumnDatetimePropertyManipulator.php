<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
final class ColumnDatetimePropertyManipulator
{
    public function removeDefaultOption(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode $columnTagValueNode) : void
    {
        $options = $columnTagValueNode->getOptions();
        unset($options['default']);
        $columnTagValueNode->changeItem('options', $options);
    }
}
