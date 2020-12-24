<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasUsesResolver
{
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
            $node = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
            return $this->resolveForNamespace($node);
        }
        return [];
    }
    /**
     * @return string[]
     */
    private function resolveForNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $aliasedUses = [];
        $this->useImportsTraverser->traverserStmts($namespace->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$aliasedUses) : void {
            if ($useUse->alias === null) {
                return;
            }
            $aliasedUses[] = $name;
        });
        return $aliasedUses;
    }
}
