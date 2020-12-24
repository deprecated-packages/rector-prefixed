<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Exclusion\Check;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Const_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\Exclusion\Check\ExcludeByDocBlockExclusionCheckTest
 */
final class ExcludeByDocBlockExclusionCheck implements \_PhpScopere8e811afab72\Rector\Core\Contract\Exclusion\ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Const_) {
            $node = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                return \false;
            }
        }
        if ($this->hasNoRectorPhpDocTagMatch($node, $phpRector)) {
            return \true;
        }
        // recurse up until a Stmt node is found since it might contain a noRector
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt && $parentNode !== null) {
            return $this->isNodeSkippedByRector($phpRector, $parentNode);
        }
        return \false;
    }
    private function hasNoRectorPhpDocTagMatch(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        /** @var PhpDocTagNode[] $noRectorTags */
        $noRectorTags = \array_merge($phpDocInfo->getTagsByName('noRector'), $phpDocInfo->getTagsByName('norector'));
        foreach ($noRectorTags as $noRectorTag) {
            if ($noRectorTag->value instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
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
