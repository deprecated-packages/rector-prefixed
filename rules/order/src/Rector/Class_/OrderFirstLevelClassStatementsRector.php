<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Order\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderFirstLevelClassStatementsRector\OrderFirstLevelClassStatementsRectorTest
 */
final class OrderFirstLevelClassStatementsRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Orders first level Class statements', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function functionName();
    protected $propertyName;
    private const CONST_NAME = 'constant_value';
    use TraitName;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    use TraitName;
    private const CONST_NAME = 'constant_value';
    protected $propertyName;
    public function functionName();
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $node->stmts = $this->getStmtsInDesiredPosition($node->stmts);
        return $node;
    }
    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function getStmtsInDesiredPosition(array $stmts) : array
    {
        \uasort($stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $firstStmt, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $secondStmt) : int {
            return [$this->resolveClassElementRank($firstStmt), $firstStmt->getLine()] <=> [$this->resolveClassElementRank($secondStmt), $secondStmt->getLine()];
        });
        return $stmts;
    }
    private function resolveClassElementRank(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt) : int
    {
        if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            return 3;
        }
        if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property) {
            return 2;
        }
        if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst) {
            return 1;
        }
        // TraitUse
        return 0;
    }
}
