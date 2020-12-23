<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasUsesResolver
{
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            $node = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            return $this->resolveForNamespace($node);
        }
        return [];
    }
    /**
     * @return string[]
     */
    private function resolveForNamespace(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $aliasedUses = [];
        $this->useImportsTraverser->traverserStmts($namespace->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$aliasedUses) : void {
            if ($useUse->alias === null) {
                return;
            }
            $aliasedUses[] = $name;
        });
        return $aliasedUses;
    }
}
