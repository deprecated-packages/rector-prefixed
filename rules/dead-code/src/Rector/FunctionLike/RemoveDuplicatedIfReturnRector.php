<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\If_;
use PhpParser\NodeTraverser;
use Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\NodeCollector\ModifiedVariableNamesCollector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2945
 *
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveDuplicatedIfReturnRector\RemoveDuplicatedIfReturnRectorTest
 */
final class RemoveDuplicatedIfReturnRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ModifiedVariableNamesCollector
     */
    private $modifiedVariableNamesCollector;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \Rector\DeadCode\NodeCollector\ModifiedVariableNamesCollector $modifiedVariableNamesCollector)
    {
        $this->ifManipulator = $ifManipulator;
        $this->modifiedVariableNamesCollector = $modifiedVariableNamesCollector;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated if stmt with return in function/method body', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        if ($value) {
            return true;
        }

        $value2 = 100;

        if ($value) {
            return true;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        if ($value) {
            return true;
        }

        $value2 = 100;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\FunctionLike::class];
    }
    /**
     * @param FunctionLike $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $ifWithOnlyReturnsByHash = $this->collectDuplicatedIfWithOnlyReturnByHash($node);
        if ($ifWithOnlyReturnsByHash === []) {
            return null;
        }
        foreach ($ifWithOnlyReturnsByHash as $stmts) {
            // keep first one
            \array_shift($stmts);
            foreach ($stmts as $stmt) {
                $this->removeNode($stmt);
            }
        }
        return $node;
    }
    /**
     * @return If_[][]
     */
    private function collectDuplicatedIfWithOnlyReturnByHash(\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $ifWithOnlyReturnsByHash = [];
        $modifiedVariableNames = [];
        foreach ((array) $functionLike->getStmts() as $stmt) {
            if (!$this->ifManipulator->isIfWithOnlyReturn($stmt)) {
                // variable modification
                $modifiedVariableNames = \array_merge($modifiedVariableNames, $this->modifiedVariableNamesCollector->collectModifiedVariableNames($stmt));
                continue;
            }
            if ($this->containsVariableNames($stmt, $modifiedVariableNames)) {
                continue;
            }
            /** @var If_ $stmt */
            $hash = $this->printWithoutComments($stmt);
            $ifWithOnlyReturnsByHash[$hash][] = $stmt;
        }
        return $this->filterOutSingleItemStmts($ifWithOnlyReturnsByHash);
    }
    /**
     * @param string[] $modifiedVariableNames
     */
    private function containsVariableNames(\PhpParser\Node\Stmt $stmt, array $modifiedVariableNames) : bool
    {
        if ($modifiedVariableNames === []) {
            return \false;
        }
        $containsVariableNames = \false;
        $this->traverseNodesWithCallable($stmt, function (\PhpParser\Node $node) use($modifiedVariableNames, &$containsVariableNames) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->isNames($node, $modifiedVariableNames)) {
                return null;
            }
            $containsVariableNames = \true;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $containsVariableNames;
    }
    /**
     * @param array<string, If_[]> $ifWithOnlyReturnsByHash
     * @return array<string, If_[]>
     */
    private function filterOutSingleItemStmts(array $ifWithOnlyReturnsByHash) : array
    {
        return \array_filter($ifWithOnlyReturnsByHash, function (array $stmts) : bool {
            return \count($stmts) >= 2;
        });
    }
}
