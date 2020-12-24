<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasUsesResolver
{
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            $node = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            return $this->resolveForNamespace($node);
        }
        return [];
    }
    /**
     * @return string[]
     */
    private function resolveForNamespace(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $aliasedUses = [];
        $this->useImportsTraverser->traverserStmts($namespace->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$aliasedUses) : void {
            if ($useUse->alias === null) {
                return;
            }
            $aliasedUses[] = $name;
        });
        return $aliasedUses;
    }
}
