<?php

declare(strict_types=1);

namespace Rector\CodingStyle\ClassNameImport;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\UseUse;
use Rector\Core\PhpParser\Node\BetterNodeFinder;

final class AliasUsesResolver
{
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    public function __construct(UseImportsTraverser $useImportsTraverser, BetterNodeFinder $betterNodeFinder)
    {
        $this->useImportsTraverser = $useImportsTraverser;
        $this->betterNodeFinder = $betterNodeFinder;
    }

    /**
     * @return string[]
     */
    public function resolveForNode(Node $node): array
    {
        if (! $node instanceof Namespace_) {
            $node = $this->betterNodeFinder->findParentType($node, Namespace_::class);
        }

        if ($node instanceof Namespace_) {
            return $this->resolveForNamespace($node);
        }

        return [];
    }

    /**
     * @return string[]
     */
    private function resolveForNamespace(Namespace_ $namespace): array
    {
        $aliasedUses = [];

        $this->useImportsTraverser->traverserStmts($namespace->stmts, function (
            UseUse $useUse,
            string $name
        ) use (&$aliasedUses) {
            if ($useUse->alias === null) {
                return;
            }

            $aliasedUses[] = $name;
        });

        return $aliasedUses;
    }
}
