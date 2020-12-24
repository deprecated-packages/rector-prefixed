<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchParamTypeExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\Guard\BreakingVariableRenameGuard;
use _PhpScopere8e811afab72\Rector\Naming\Naming\ExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\ParamRenamer\ParamRenamer;
use _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\ParamRenameFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\ClassMethod\RenameParamToMatchTypeRector\RenameParamToMatchTypeRectorTest
 */
final class RenameParamToMatchTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @var ExpectedNameResolver
     */
    private $expectedNameResolver;
    /**
     * @var BreakingVariableRenameGuard
     */
    private $breakingVariableRenameGuard;
    /**
     * @var ParamRenamer
     */
    private $paramRenamer;
    /**
     * @var ParamRenameFactory
     */
    private $paramRenameFactory;
    /**
     * @var MatchParamTypeExpectedNameResolver
     */
    private $matchParamTypeExpectedNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \_PhpScopere8e811afab72\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchParamTypeExpectedNameResolver $matchParamTypeExpectedNameResolver, \_PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\ParamRenameFactory $paramRenameFactory, \_PhpScopere8e811afab72\Rector\Naming\ParamRenamer\ParamRenamer $paramRenamer)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->paramRenameFactory = $paramRenameFactory;
        $this->paramRenamer = $paramRenamer;
        $this->matchParamTypeExpectedNameResolver = $matchParamTypeExpectedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename variable to match new ClassType', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(Apple $pie)
    {
        $food = $pie;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(Apple $apple)
    {
        $food = $apple;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->hasChanged = \false;
        foreach ($node->params as $param) {
            $expectedName = $this->expectedNameResolver->resolveForParamIfNotYet($param);
            if ($expectedName === null) {
                continue;
            }
            if ($this->shouldSkipParam($param, $expectedName, $node)) {
                continue;
            }
            $paramRename = $this->paramRenameFactory->create($param, $this->matchParamTypeExpectedNameResolver);
            if ($paramRename === null) {
                continue;
            }
            $matchTypeParamRenamerRename = $this->paramRenamer->rename($paramRename);
            if ($matchTypeParamRenamerRename === null) {
                continue;
            }
            $this->hasChanged = \true;
        }
        if (!$this->hasChanged) {
            return null;
        }
        return $node;
    }
    private function shouldSkipParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, string $expectedName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $paramName */
        $paramName = $this->getName($param);
        return $this->breakingVariableRenameGuard->shouldSkipParam($paramName, $expectedName, $classMethod, $param);
    }
}
