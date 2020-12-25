<?php

declare (strict_types=1);
namespace Rector\Core\Exclusion\Check;

use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\PropertyProperty;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\Exclusion\Check\ExcludeByDocBlockExclusionCheckTest
 */
final class ExcludeByDocBlockExclusionCheck implements \Rector\Core\Contract\Exclusion\ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \PhpParser\Node $node) : bool
    {
        if ($node instanceof \PhpParser\Node\Stmt\PropertyProperty || $node instanceof \PhpParser\Node\Const_) {
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                return \false;
            }
        }
        if ($this->hasNoRectorPhpDocTagMatch($node, $phpRector)) {
            return \true;
        }
        // recurse up until a Stmt node is found since it might contain a noRector
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \PhpParser\Node\Stmt && $parentNode !== null) {
            return $this->isNodeSkippedByRector($phpRector, $parentNode);
        }
        return \false;
    }
    private function hasNoRectorPhpDocTagMatch(\PhpParser\Node $node, \Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool
    {
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        /** @var PhpDocTagNode[] $noRectorTags */
        $noRectorTags = \array_merge($phpDocInfo->getTagsByName('noRector'), $phpDocInfo->getTagsByName('norector'));
        foreach ($noRectorTags as $noRectorTag) {
            if ($noRectorTag->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                $rectorClass = \get_class($phpRector);
                if ($noRectorTag->value->value === $rectorClass) {
                    return \true;
                }
                if ($noRectorTag->value->value === '\\' . $rectorClass) {
                    return \true;
                }
                if ($noRectorTag->value->value === '') {
                    return \true;
                }
            }
        }
        return \false;
    }
}
