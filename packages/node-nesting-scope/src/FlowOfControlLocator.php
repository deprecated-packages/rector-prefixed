<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeNestingScope;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FlowOfControlLocator
{
    public function resolveNestingHashFromFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PhpParser\Node $checkedNode) : string
    {
        $nestingHash = \spl_object_hash($functionLike) . '__';
        $currentNode = $checkedNode;
        $previous = $currentNode;
        while ($currentNode = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE)) {
            if ($currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
                continue;
            }
            if ($functionLike === $currentNode) {
                // to high
                break;
            }
            $nestingHash .= $this->resolveBinaryOpNestingHash($currentNode, $previous);
            $nestingHash .= \spl_object_hash($currentNode);
            $previous = $currentNode;
        }
        return $nestingHash;
    }
    private function resolveBinaryOpNestingHash(\_PhpScopere8e811afab72\PhpParser\Node $currentNode, \_PhpScopere8e811afab72\PhpParser\Node $previous) : string
    {
        if (!$currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return '';
        }
        // left && right have differnt nesting
        if ($currentNode->left === $previous) {
            return 'binary_left__';
        }
        if ($currentNode->right === $previous) {
            return 'binary_right__';
        }
        return '';
    }
}
