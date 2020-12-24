<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\FunctionLike;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeCollector\ModifiedVariableNamesCollector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2945
 *
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveDuplicatedIfReturnRector\RemoveDuplicatedIfReturnRectorTest
 */
final class RemoveDuplicatedIfReturnRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ModifiedVariableNamesCollector
     */
    private $modifiedVariableNamesCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeCollector\ModifiedVariableNamesCollector $modifiedVariableNamesCollector)
    {
        $this->ifManipulator = $ifManipulator;
        $this->modifiedVariableNamesCollector = $modifiedVariableNamesCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated if stmt with return in function/method body', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike::class];
    }
    /**
     * @param FunctionLike $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function collectDuplicatedIfWithOnlyReturnByHash(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : array
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
    private function containsVariableNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt, array $modifiedVariableNames) : bool
    {
        if ($modifiedVariableNames === []) {
            return \false;
        }
        $containsVariableNames = \false;
        $this->traverseNodesWithCallable($stmt, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($modifiedVariableNames, &$containsVariableNames) : ?int {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->isNames($node, $modifiedVariableNames)) {
                return null;
            }
            $containsVariableNames = \true;
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::STOP_TRAVERSAL;
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
