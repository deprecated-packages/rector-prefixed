<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Generic\Rector\AbstractToMethodCallRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\FuncCallToMethodCallRectorTest
 */
final class FuncCallToMethodCallRector extends \_PhpScopere8e811afab72\Rector\Generic\Rector\AbstractToMethodCallRector
{
    /**
     * @var string
     */
    public const FUNC_CALL_TO_CLASS_METHOD_CALL = 'function_to_class_to_method_call';
    /**
     * @var FuncNameToMethodCallName[]
     */
    private $funcNameToMethodCallNames = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function calls to local method calls.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        view('...');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Namespaced\SomeRenderer
     */
    private $someRenderer;

    public function __construct(\Namespaced\SomeRenderer $someRenderer)
    {
        $this->someRenderer = $someRenderer;
    }

    public function run()
    {
        $this->someRenderer->view('...');
    }
}
CODE_SAMPLE
, [self::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScopere8e811afab72\\Namespaced\\SomeRenderer', 'render')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        if ($classMethod->isStatic()) {
            return null;
        }
        foreach ($this->funcNameToMethodCallNames as $funcNameToMethodCallName) {
            if (!$this->isName($node->name, $funcNameToMethodCallName->getOldFuncName())) {
                continue;
            }
            $expr = $this->matchTypeProvidingExpr($classLike, $classMethod, $funcNameToMethodCallName->getNewClassName());
            return $this->createMethodCall($expr, $funcNameToMethodCallName->getNewMethodName(), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $funcCallsToClassMethodCalls = $configuration[self::FUNC_CALL_TO_CLASS_METHOD_CALL] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($funcCallsToClassMethodCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName::class);
        $this->funcNameToMethodCallNames = $funcCallsToClassMethodCalls;
    }
}
