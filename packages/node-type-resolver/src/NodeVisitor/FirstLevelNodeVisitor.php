<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeVisitorAbstract;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class FirstLevelNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /**
     * @return Node
     */
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\FunctionLike) {
            foreach ((array) $node->getStmts() as $stmt) {
                $stmt->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT, \true);
                if ($stmt instanceof \PhpParser\Node\Stmt\Expression) {
                    $stmt->expr->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT, \true);
                }
            }
        }
        return null;
    }
}
