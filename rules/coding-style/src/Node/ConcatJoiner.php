<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ConcatJoiner
{
    /**
     * @var string
     */
    private $content;
    /**
     * @var Expr[]
     */
    private $placeholderNodes = [];
    /**
     * Joins all String_ nodes to string.
     * Returns that string + array of non-string nodes that were replaced by hash placeholders
     */
    public function joinToStringAndPlaceholderNodes(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders
    {
        $parentNode = $concat->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            $this->reset();
        }
        $this->processConcatSide($concat->left);
        $this->processConcatSide($concat->right);
        return new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders($this->content, $this->placeholderNodes);
    }
    private function reset() : void
    {
        $this->content = '';
        $this->placeholderNodes = [];
    }
    private function processConcatSide(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : void
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            $this->content .= $expr->value;
        } elseif ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            $this->joinToStringAndPlaceholderNodes($expr);
        } else {
            $objectHash = '____' . \spl_object_hash($expr) . '____';
            $this->placeholderNodes[$objectHash] = $expr;
            $this->content .= $objectHash;
        }
    }
}
