<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Foreach_;

use RectorPrefix20210305\Doctrine\Inflector\Inflector;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Foreach_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector\RenameForeachValueVariableToMatchExprVariableRectorTest
 */
final class RenameForeachValueVariableToMatchExprVariableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var Inflector
     */
    private $inflector;
    public function __construct(\RectorPrefix20210305\Doctrine\Inflector\Inflector $inflector)
    {
        $this->inflector = $inflector;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames value variable name in foreach loop to match expression variable', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
public function run()
{
    $array = [];
    foreach ($variables as $foo) {
        $array[] = $property;
    }
}
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
public function run()
{
    $array = [];
    foreach ($variables as $variable) {
        $array[] = $variable;
    }
}
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\Variable && !$node->expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $exprName = $this->getName($node->expr);
        if ($exprName === null) {
            return null;
        }
        $keyVarName = $node->keyVar === null ? '' : (string) $this->getName($node->keyVar);
        $valueVarName = $this->getName($node->valueVar);
        if ($valueVarName === null) {
            return null;
        }
        $singularValueVarName = $this->inflector->singularize($exprName);
        $singularValueVarName = $singularValueVarName === $exprName ? 'single' . \ucfirst(\ltrim($singularValueVarName, 'single')) : $singularValueVarName;
        if ($this->shouldSkip($keyVarName, $valueVarName, $singularValueVarName, $node)) {
            return null;
        }
        return $this->processRename($node, $valueVarName, $singularValueVarName);
    }
    private function processRename(\PhpParser\Node\Stmt\Foreach_ $foreach, string $valueVarName, string $singularValueVarName) : \PhpParser\Node\Stmt\Foreach_
    {
        $foreach->valueVar = new \PhpParser\Node\Expr\Variable($singularValueVarName);
        $this->traverseNodesWithCallable($foreach->stmts, function (\PhpParser\Node $node) use($singularValueVarName, $valueVarName) : ?Variable {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->isName($node, $valueVarName)) {
                return null;
            }
            return new \PhpParser\Node\Expr\Variable($singularValueVarName);
        });
        return $foreach;
    }
    private function shouldSkip(string $keyVarName, string $valueVarName, string $singularValueVarName, \PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        if ($singularValueVarName === $valueVarName) {
            return \true;
        }
        $isUsedInStmts = (bool) $this->betterNodeFinder->findFirst($foreach->stmts, function (\PhpParser\Node $node) use($singularValueVarName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->isName($node, $singularValueVarName);
        });
        if ($isUsedInStmts) {
            return \true;
        }
        $isUsedInNextForeach = (bool) $this->betterNodeFinder->findFirstNext($foreach, function (\PhpParser\Node $node) use($singularValueVarName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->isName($node, $singularValueVarName);
        });
        if ($isUsedInNextForeach) {
            return \true;
        }
        return $keyVarName === $singularValueVarName;
    }
}
