<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\AbstractToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\FuncCallToMethodCallRectorTest
 */
final class FuncCallToMethodCallRector extends \_PhpScoper0a6b37af0871\Rector\Generic\Rector\AbstractToMethodCallRector
{
    /**
     * @var string
     */
    public const FUNC_CALL_TO_CLASS_METHOD_CALL = 'function_to_class_to_method_call';
    /**
     * @var FuncNameToMethodCallName[]
     */
    private $funcNameToMethodCallNames = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function calls to local method calls.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::FUNC_CALL_TO_CLASS_METHOD_CALL => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName('view', '_PhpScoper0a6b37af0871\\Namespaced\\SomeRenderer', 'render')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
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
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($funcCallsToClassMethodCalls, \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName::class);
        $this->funcNameToMethodCallNames = $funcCallsToClassMethodCalls;
    }
}
