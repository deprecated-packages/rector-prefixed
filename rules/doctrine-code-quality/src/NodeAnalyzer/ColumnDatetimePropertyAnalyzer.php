<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ColumnDatetimePropertyAnalyzer
{
    public function matchDateTimeColumnTagValueNodeInProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $columnTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($columnTagValueNode === null) {
            return null;
        }
        /** @var ColumnTagValueNode $columnTagValueNode */
        if ($columnTagValueNode->getType() !== 'datetime') {
            return null;
        }
        return $columnTagValueNode;
    }
}
