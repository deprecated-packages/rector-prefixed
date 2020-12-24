<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderFirstLevelClassStatementsRector\OrderFirstLevelClassStatementsRectorTest
 */
final class OrderFirstLevelClassStatementsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Orders first level Class statements', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
        \uasort($stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $firstStmt, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $secondStmt) : int {
            return [$this->resolveClassElementRank($firstStmt), $firstStmt->getLine()] <=> [$this->resolveClassElementRank($secondStmt), $secondStmt->getLine()];
        });
        return $stmts;
    }
    private function resolveClassElementRank(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt) : int
    {
        if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            return 3;
        }
        if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property) {
            return 2;
        }
        if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst) {
            return 1;
        }
        // TraitUse
        return 0;
    }
}
