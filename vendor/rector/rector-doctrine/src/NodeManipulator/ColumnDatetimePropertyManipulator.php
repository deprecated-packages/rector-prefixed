<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeManipulator;

use Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode;
final class ColumnDatetimePropertyManipulator
{
    public function removeDefaultOption(\Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode $columnTagValueNode) : void
    {
        $options = $columnTagValueNode->getOptions();
        unset($options['default']);
        $columnTagValueNode->changeItem('options', $options);
    }
}
