<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
final class ColumnDatetimePropertyManipulator
{
    public function removeDefaultOption(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode $columnTagValueNode) : void
    {
        $options = $columnTagValueNode->getOptions();
        unset($options['default']);
        $columnTagValueNode->changeItem('options', $options);
    }
}
