<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Exclusion\Check;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Const_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\Exclusion\Check\ExcludeByDocBlockExclusionCheckTest
 */
final class ExcludeByDocBlockExclusionCheck implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Exclusion\ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Const_) {
            $node = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                return \false;
            }
        }
        if ($this->hasNoRectorPhpDocTagMatch($node, $phpRector)) {
            return \true;
        }
        // recurse up until a Stmt node is found since it might contain a noRector
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt && $parentNode !== null) {
            return $this->isNodeSkippedByRector($phpRector, $parentNode);
        }
        return \false;
    }
    private function hasNoRectorPhpDocTagMatch(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        /** @var PhpDocTagNode[] $noRectorTags */
        $noRectorTags = \array_merge($phpDocInfo->getTagsByName('noRector'), $phpDocInfo->getTagsByName('norector'));
        foreach ($noRectorTags as $noRectorTag) {
            if ($noRectorTag->value instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
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
