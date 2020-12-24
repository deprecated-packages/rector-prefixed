<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Rector\Foreach_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Guard\BreakingVariableRenameGuard;
use _PhpScopere8e811afab72\Rector\Naming\Matcher\ForeachMatcher;
use _PhpScopere8e811afab72\Rector\Naming\Naming\ExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\NamingConvention\NamingConventionAnalyzer;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach;
use _PhpScopere8e811afab72\Rector\Naming\VariableRenamer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector\RenameForeachValueVariableToMatchMethodCallReturnTypeRectorTest
 */
final class RenameForeachValueVariableToMatchMethodCallReturnTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \_PhpScopere8e811afab72\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScopere8e811afab72\Rector\Naming\NamingConvention\NamingConventionAnalyzer $namingConventionAnalyzer, \_PhpScopere8e811afab72\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScopere8e811afab72\Rector\Naming\Matcher\ForeachMatcher $foreachMatcher)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->namingConventionAnalyzer = $namingConventionAnalyzer;
        $this->varValueAndCallForeachMatcher = $foreachMatcher;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames value variable name in foreach loop to match method type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var VariableAndCallForeach|null $variableAndCallAssign */
        $variableAndCallAssign = $this->varValueAndCallForeachMatcher->match($node);
        if ($variableAndCallAssign === null) {
            return null;
        }
        $expectedName = $this->expectedNameResolver->resolveForForeach($variableAndCallAssign->getCall());
        if ($expectedName === null || $this->isName($variableAndCallAssign->getVariable(), $expectedName)) {
            return null;
        }
        if ($this->shouldSkip($variableAndCallAssign, $expectedName)) {
            return null;
        }
        $this->renameVariable($variableAndCallAssign, $expectedName);
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : bool
    {
        if ($this->namingConventionAnalyzer->isCallMatchingVariableName($variableAndCallForeach->getCall(), $variableAndCallForeach->getVariableName(), $expectedName)) {
            return \true;
        }
        return $this->breakingVariableRenameGuard->shouldSkipVariable($variableAndCallForeach->getVariableName(), $expectedName, $variableAndCallForeach->getFunctionLike(), $variableAndCallForeach->getVariable());
    }
    private function renameVariable(\_PhpScopere8e811afab72\Rector\Naming\ValueObject\VariableAndCallForeach $variableAndCallForeach, string $expectedName) : void
    {
        $this->variableRenamer->renameVariableInFunctionLike($variableAndCallForeach->getFunctionLike(), null, $variableAndCallForeach->getVariableName(), $expectedName);
    }
}
