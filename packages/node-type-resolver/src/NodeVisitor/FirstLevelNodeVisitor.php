<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class FirstLevelNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
{
    /**
     * @return Node
     */
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike) {
            foreach ((array) $node->getStmts() as $stmt) {
                $stmt->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT, \true);
                if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                    $stmt->expr->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT, \true);
                }
            }
        }
        return null;
    }
}
