<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Generic\Rector\AbstractToMethodCallRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Transform\ValueObject\FuncNameToMethodCallName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperbf340cb0be9d\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\FuncCallToMethodCallRectorTest
 */
final class FuncCallToMethodCallRector extends \Rector\Generic\Rector\AbstractToMethodCallRector
{
    /**
     * @var string
     */
    public const FUNC_CALL_TO_CLASS_METHOD_CALL = 'function_to_class_to_method_call';
    /**
     * @var FuncNameToMethodCallName[]
     */
    private $funcNameToMethodCallNames = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function calls to local method calls.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScoperbf340cb0be9d\\Namespaced\\SomeRenderer', 'render')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
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
        \_PhpScoperbf340cb0be9d\Webmozart\Assert\Assert::allIsInstanceOf($funcCallsToClassMethodCalls, \Rector\Transform\ValueObject\FuncNameToMethodCallName::class);
        $this->funcNameToMethodCallNames = $funcCallsToClassMethodCalls;
    }
}
