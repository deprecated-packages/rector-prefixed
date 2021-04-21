<?php

declare(strict_types=1);

namespace Rector\CodingStyle\Application;

use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;

final class UseImportsRemover
{
    /**
     * @param Stmt[] $stmts
     * @param string[] $removedShortUses
     * @return Stmt[]
     */
    public function removeImportsFromStmts(array $stmts, array $removedShortUses): array
    {
        foreach ($stmts as $stmtKey => $stmt) {
            if (! $stmt instanceof Use_) {
                continue;
            }

            $this->removeUseFromUse($removedShortUses, $stmt);

            // nothing left → remove
            if ($stmt->uses === []) {
                unset($stmts[$stmtKey]);
            }
        }

        return $stmts;
    }

    /**
     * @param string[] $removedShortUses
     * @return void
     */
    public function removeImportsFromNamespace(Namespace_ $namespace, array $removedShortUses)
    {
        foreach ($namespace->stmts as $namespaceKey => $stmt) {
            if (! $stmt instanceof Use_) {
                continue;
            }

            $this->removeUseFromUse($removedShortUses, $stmt);

            // nothing left → remove
            if ($stmt->uses === []) {
                unset($namespace->stmts[$namespaceKey]);
            }
        }
    }

    /**
     * @param string[] $removedShortUses
     * @return void
     */
    private function removeUseFromUse(array $removedShortUses, Use_ $use)
    {
        foreach ($use->uses as $usesKey => $useUse) {
            foreach ($removedShortUses as $removedShortUse) {
                if ($useUse->name->getLast() !== $removedShortUse) {
                    continue;
                }

                unset($use->uses[$usesKey]);
            }
        }
    }
}
