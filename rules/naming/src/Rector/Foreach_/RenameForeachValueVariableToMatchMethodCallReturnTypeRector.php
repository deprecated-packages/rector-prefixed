<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Foreach_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Foreach_;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Guard\BreakingVariableRenameGuard;
use Rector\Naming\Matcher\ForeachMatcher;
use Rector\Naming\Naming\ExpectedNameResolver;
use Rector\Naming\NamingConvention\NamingConventionAnalyzer;
use Rector\Naming\ValueObject\VariableAndCallForeach;
use Rector\Naming\VariableRenamer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector\RenameForeachValueVariableToMatchMethodCallReturnTypeRectorTest
 */
final class RenameForeachValueVariableToMatchMethodCallReturnTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ExpectedNameResolver
     */
    private $expectedNameResolver;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var ForeachMatcher
     */
    private $varValueAndCallForeachMatcher;
    /**
     * @var BreakingVariableRenameGuard
     */
    private $breakingVariableRenameGuard;
    /**
     * @var NamingConventionAnalyzer
     */
    private $namingConventionAnalyzer;
    public function __construct(\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \Rector\Naming\NamingConvention\NamingConventionAnalyzer $namingConventionAnalyzer, \Rector\Naming\VariableRenamer $variableRenamer, \Rector\Naming\Matcher\ForeachMatcher $foreachMatcher)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->namingConventionAnalyzer = $namingConventionAnalyzer;
        $this->varValueAndCallForeachMatcher = $foreachMatcher;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames value variable name in foreach loop to match method type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $array = [];
        foreach ($object->getMethods() as $property) {
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
        foreach ($object->getMethods() as $method) {
            $array[] = $method;
        }
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
        return [\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $variableAndCallAssign = $this->varValueAndCallForeachMatcher->match($node);
        if (!$variableAndCallAssign instanceof \Rector\Naming\ValueObject\VariableAndCallForeach) {
            return null;
        }
        $expectedName = $this->expectedNameResolver->resolveForForeach($variableAndCallAssign->getCall());
        if ($expectedName === null) {
            return null;
        }
        if ($this->isName($variableAndCallAssign->getVariable(), $expectedName)) {
            return null;
        }
        if ($this->shouldSkip($variableAndCallAssign, $expectedName)) {
            return null;
        }
        $this->renameVariable($variableAndCallAssign, $expectedName);
        return $node;
    }
    private function shouldSkip(\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : bool
    {
        if ($this->namingConventionAnalyzer->isCallMatchingVariableName($variableAndCallForeach->getCall(), $variableAndCallForeach->getVariableName(), $expectedName)) {
            return \true;
        }
        return $this->breakingVariableRenameGuard->shouldSkipVariable($variableAndCallForeach->getVariableName(), $expectedName, $variableAndCallForeach->getFunctionLike(), $variableAndCallForeach->getVariable());
    }
    private function renameVariable(\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : void
    {
        $this->variableRenamer->renameVariableInFunctionLike($variableAndCallForeach->getFunctionLike(), null, $variableAndCallForeach->getVariableName(), $expectedName);
    }
}
