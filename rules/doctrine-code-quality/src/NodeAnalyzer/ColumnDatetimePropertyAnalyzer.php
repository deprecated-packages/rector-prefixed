<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\NodeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
final class ColumnDatetimePropertyAnalyzer
{
    public function matchDateTimeColumnTagValueNodeInProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $columnTagValueNode = $phpDocInfo->getByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
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
