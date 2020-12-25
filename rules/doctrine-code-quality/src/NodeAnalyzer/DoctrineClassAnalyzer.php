<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\NodeAnalyzer;

use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class DoctrineClassAnalyzer
{
    public function matchDoctrineEntityTagValueNode(\PhpParser\Node\Stmt\Class_ $class) : ?\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
    }
}
