<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Exclusion\Check;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Const_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\Exclusion\Check\ExcludeByDocBlockExclusionCheckTest
 */
final class ExcludeByDocBlockExclusionCheck implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Exclusion\ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Const_) {
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                return \false;
            }
        }
        if ($this->hasNoRectorPhpDocTagMatch($node, $phpRector)) {
            return \true;
        }
        // recurse up until a Stmt node is found since it might contain a noRector
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt && $parentNode !== null) {
            return $this->isNodeSkippedByRector($phpRector, $parentNode);
        }
        return \false;
    }
    private function hasNoRectorPhpDocTagMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        /** @var PhpDocTagNode[] $noRectorTags */
        $noRectorTags = \array_merge($phpDocInfo->getTagsByName('noRector'), $phpDocInfo->getTagsByName('norector'));
        foreach ($noRectorTags as $noRectorTag) {
            if ($noRectorTag->value instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
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
