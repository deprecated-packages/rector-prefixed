<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function joinToStringAndPlaceholderNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders
    {
        $parentNode = $concat->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat) {
            $this->reset();
        }
        $this->processConcatSide($concat->left);
        $this->processConcatSide($concat->right);
        return new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ConcatStringAndPlaceholders($this->content, $this->placeholderNodes);
    }
    private function reset() : void
    {
        $this->content = '';
        $this->placeholderNodes = [];
    }
    private function processConcatSide(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : void
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            $this->content .= $expr->value;
        } elseif ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat) {
            $this->joinToStringAndPlaceholderNodes($expr);
        } else {
            $objectHash = '____' . \spl_object_hash($expr) . '____';
            $this->placeholderNodes[$objectHash] = $expr;
            $this->content .= $objectHash;
        }
    }
}
