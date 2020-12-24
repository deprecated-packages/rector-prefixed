<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
/**
 * @see \Rector\Order\Tests\StmtOrderTest
 */
final class StmtOrder
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param array<int, string> $desiredStmtOrder
     * @param array<int, string> $currentStmtOrder
     * @return array<int, int>
     */
    public function createOldToNewKeys(array $desiredStmtOrder, array $currentStmtOrder) : array
    {
        $newKeys = [];
        foreach ($desiredStmtOrder as $desiredClassMethod) {
            foreach ($currentStmtOrder as $currentKey => $classMethodName) {
                if ($classMethodName === $desiredClassMethod) {
                    $newKeys[] = $currentKey;
                }
            }
        }
        $oldKeys = \array_values($newKeys);
        \sort($oldKeys);
        /** @var array<int, int> $oldToNewKeys */
        $oldToNewKeys = \array_combine($oldKeys, $newKeys);
        return $oldToNewKeys;
    }
    /**
     * @param array<int, int> $oldToNewKeys
     */
    public function reorderClassStmtsByOldToNewKeys(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, array $oldToNewKeys) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike
    {
        $reorderedStmts = [];
        $stmtCount = \count((array) $classLike->stmts);
        foreach ($classLike->stmts as $key => $stmt) {
            if (!\array_key_exists($key, $oldToNewKeys)) {
                $reorderedStmts[$key] = $stmt;
                continue;
            }
            // reorder here
            $newKey = $oldToNewKeys[$key];
            $reorderedStmts[$key] = $classLike->stmts[$newKey];
        }
        for ($i = 0; $i < $stmtCount; ++$i) {
            if (!\array_key_exists($i, $reorderedStmts)) {
                continue;
            }
            $classLike->stmts[$i] = $reorderedStmts[$i];
        }
        return $classLike;
    }
    /**
     * @return array<int,string>
     */
    public function getStmtsOfTypeOrder(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $type) : array
    {
        $stmtsByPosition = [];
        foreach ($classLike->stmts as $position => $classStmt) {
            if (!\is_a($classStmt, $type)) {
                continue;
            }
            $name = $this->nodeNameResolver->getName($classStmt);
            if ($name === null) {
                continue;
            }
            $stmtsByPosition[$position] = $name;
        }
        return $stmtsByPosition;
    }
}
