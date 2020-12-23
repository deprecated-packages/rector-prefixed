<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNestingScope;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class FlowOfControlLocator
{
    public function resolveNestingHashFromFunctionLike(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper0a2ac50786fa\PhpParser\Node $checkedNode) : string
    {
        $nestingHash = \spl_object_hash($functionLike) . '__';
        $currentNode = $checkedNode;
        $previous = $currentNode;
        while ($currentNode = $currentNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE)) {
            if ($currentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$currentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
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
    private function resolveBinaryOpNestingHash(\_PhpScoper0a2ac50786fa\PhpParser\Node $currentNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $previous) : string
    {
        if (!$currentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp) {
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
