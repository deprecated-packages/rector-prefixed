<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Foreach_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Type\ThisType;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\ExpectedNameResolver\InflectorSingularResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector\RenameForeachValueVariableToMatchExprVariableRectorTest
 */
final class RenameForeachValueVariableToMatchExprVariableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var InflectorSingularResolver
     */
    private $inflectorSingularResolver;
    /**
     * @param \Rector\Naming\ExpectedNameResolver\InflectorSingularResolver $inflectorSingularResolver
     */
    public function __construct($inflectorSingularResolver)
    {
        $this->inflectorSingularResolver = $inflectorSingularResolver;
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
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\Variable && !$node->expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if ($this->isNotThisTypePropertyFetch($node->expr)) {
            return null;
        }
        $exprName = $this->getName($node->expr);
        if ($exprName === null) {
            return null;
        }
        if ($node->keyVar instanceof \PhpParser\Node) {
            return null;
        }
        $valueVarName = $this->getName($node->valueVar);
        if ($valueVarName === null) {
            return null;
        }
        $singularValueVarName = $this->inflectorSingularResolver->resolve($exprName);
        if ($this->shouldSkip($valueVarName, $singularValueVarName, $node)) {
            return null;
        }
        return $this->processRename($node, $valueVarName, $singularValueVarName);
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     */
    private function isNotThisTypePropertyFetch($expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            $variableType = $this->getStaticType($expr->var);
            return !$variableType instanceof \PHPStan\Type\ThisType;
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node\Stmt\Foreach_ $foreach
     * @param string $valueVarName
     * @param string $singularValueVarName
     */
    private function processRename($foreach, $valueVarName, $singularValueVarName) : \PhpParser\Node\Stmt\Foreach_
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
    /**
     * @param string $valueVarName
     * @param string $singularValueVarName
     * @param \PhpParser\Node\Stmt\Foreach_ $foreach
     */
    private function shouldSkip($valueVarName, $singularValueVarName, $foreach) : bool
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
        return (bool) $this->betterNodeFinder->findFirstNext($foreach, function (\PhpParser\Node $node) use($singularValueVarName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->isName($node, $singularValueVarName);
        });
    }
}
