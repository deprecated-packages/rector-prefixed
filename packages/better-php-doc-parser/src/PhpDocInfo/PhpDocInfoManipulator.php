<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocInfo;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class PhpDocInfoManipulator
{
    public function getPhpDocTagValueNode(\PhpParser\Node $node, string $phpDocTagNodeClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getByType($phpDocTagNodeClass);
    }
}
