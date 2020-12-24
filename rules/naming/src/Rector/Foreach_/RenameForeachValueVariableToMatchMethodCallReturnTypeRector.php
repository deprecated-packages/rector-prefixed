<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Foreach_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard\BreakingVariableRenameGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher\ForeachMatcher;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ExpectedNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\NamingConvention\NamingConventionAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallForeach;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector\RenameForeachValueVariableToMatchMethodCallReturnTypeRectorTest
 */
final class RenameForeachValueVariableToMatchMethodCallReturnTypeRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\NamingConvention\NamingConventionAnalyzer $namingConventionAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher\ForeachMatcher $foreachMatcher)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->namingConventionAnalyzer = $namingConventionAnalyzer;
        $this->varValueAndCallForeachMatcher = $foreachMatcher;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames value variable name in foreach loop to match method type', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        /** @var VariableAndCallForeach|null $variableAndCallAssign */
        $variableAndCallAssign = $this->varValueAndCallForeachMatcher->match($node);
        if ($variableAndCallAssign === null) {
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
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : bool
    {
        if ($this->namingConventionAnalyzer->isCallMatchingVariableName($variableAndCallForeach->getCall(), $variableAndCallForeach->getVariableName(), $expectedName)) {
            return \true;
        }
        return $this->breakingVariableRenameGuard->shouldSkipVariable($variableAndCallForeach->getVariableName(), $expectedName, $variableAndCallForeach->getFunctionLike(), $variableAndCallForeach->getVariable());
    }
    private function renameVariable(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : void
    {
        $this->variableRenamer->renameVariableInFunctionLike($variableAndCallForeach->getFunctionLike(), null, $variableAndCallForeach->getVariableName(), $expectedName);
    }
}
