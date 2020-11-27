<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ClassNameImport;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\UseUse;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasUsesResolver
{
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;
    public function __construct(\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\PhpParser\Node $node) : array
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Namespace_) {
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Namespace_) {
            return $this->resolveForNamespace($node);
        }
        return [];
    }
    /**
     * @return string[]
     */
    private function resolveForNamespace(\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $aliasedUses = [];
        $this->useImportsTraverser->traverserStmts($namespace->stmts, function (\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$aliasedUses) : void {
            if ($useUse->alias === null) {
                return;
            }
            $aliasedUses[] = $name;
        });
        return $aliasedUses;
    }
}
