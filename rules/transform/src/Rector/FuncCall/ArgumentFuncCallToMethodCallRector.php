<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\FuncCall\ArgumentFuncCallToMethodCallRector\ArgumentFuncCallToMethodCallRectorTest
 */
final class ArgumentFuncCallToMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNCTIONS_TO_METHOD_CALLS = 'functions_to_method_calls';
    /**
     * @var string
     */
    public const ARRAY_FUNCTIONS_TO_METHOD_CALLS = 'array_functions_to_method_calls';
    /**
     * @var ArgumentFuncCallToMethodCall[]
     */
    private $argumentFuncCallToMethodCalls = [];
    /**
     * @var ArrayFuncCallToMethodCall[]
     */
    private $arrayFunctionsToMethodCalls = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move help facade-like function calls to constructor injection', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function action()
    {
        $template = view('template.blade');
        $viewFactory = view();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController
{
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    private $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    public function action()
    {
        $template = $this->viewFactory->make('template.blade');
        $viewFactory = $this->viewFactory;
    }
}
CODE_SAMPLE
, [self::FUNCTIONS_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', '_PhpScopere8e811afab72\\Illuminate\\Contracts\\View\\Factory', 'make')]])]);
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
        if ($this->shouldSkipFuncCall($node)) {
            return null;
        }
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        foreach ($this->argumentFuncCallToMethodCalls as $functionToMethodCall) {
            if (!$this->isName($node, $functionToMethodCall->getFunction())) {
                continue;
            }
            return $this->refactorFuncCallToMethodCall($functionToMethodCall, $classLike, $node);
        }
        foreach ($this->arrayFunctionsToMethodCalls as $arrayFunctionsToMethodCall) {
            if (!$this->isName($node, $arrayFunctionsToMethodCall->getFunction())) {
                continue;
            }
            return $this->refactorArrayFunctionToMethodCall($arrayFunctionsToMethodCall, $node, $classLike);
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $functionToMethodCalls = $configuration[self::FUNCTIONS_TO_METHOD_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($functionToMethodCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall::class);
        $this->argumentFuncCallToMethodCalls = $functionToMethodCalls;
        $arrayFunctionsToMethodCalls = $configuration[self::ARRAY_FUNCTIONS_TO_METHOD_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($arrayFunctionsToMethodCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall::class);
        $this->arrayFunctionsToMethodCalls = $arrayFunctionsToMethodCalls;
    }
    private function shouldSkipFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        // we can inject only in injectable class method  context
        /** @var ClassMethod|null $classMethod */
        $classMethod = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return \true;
        }
        return $classMethod->isStatic();
    }
    /**
     * @return PropertyFetch|MethodCall
     */
    private function refactorFuncCallToMethodCall(\_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $fullyQualifiedObjectType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($argumentFuncCallToMethodCall->getClass());
        $expectedName = $this->propertyNaming->getExpectedNameFromType($fullyQualifiedObjectType);
        if ($expectedName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $expectedName->getName());
        $propertyFetchNode = $this->createPropertyFetch('this', $expectedName->getName());
        if ($funcCall->args === []) {
            return $this->refactorEmptyFuncCallArgs($argumentFuncCallToMethodCall, $propertyFetchNode);
        }
        if ($this->isFunctionToMethodCallWithArgs($funcCall, $argumentFuncCallToMethodCall)) {
            $methodName = $argumentFuncCallToMethodCall->getMethodIfArgs();
            if (!\is_string($methodName)) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetchNode, $methodName, $funcCall->args);
        }
        return null;
    }
    /**
     * @return PropertyFetch|MethodCall|null
     */
    private function refactorArrayFunctionToMethodCall(\_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall $arrayFuncCallToMethodCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($arrayFuncCallToMethodCall->getClass());
        $propertyFetch = $this->createPropertyFetch('this', $propertyName);
        $fullyQualifiedObjectType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($arrayFuncCallToMethodCall->getClass());
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $propertyName);
        return $this->createMethodCallArrayFunctionToMethodCall($funcCall, $arrayFuncCallToMethodCall, $propertyFetch);
    }
    /**
     * @return PropertyFetch|MethodCall
     */
    private function refactorEmptyFuncCallArgs(\_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($argumentFuncCallToMethodCall->getMethodIfNoArgs()) {
            $methodName = $argumentFuncCallToMethodCall->getMethodIfNoArgs();
            if (!\is_string($methodName)) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, $methodName);
        }
        return $propertyFetch;
    }
    private function isFunctionToMethodCallWithArgs(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall) : bool
    {
        if ($argumentFuncCallToMethodCall->getMethodIfArgs() === null) {
            return \false;
        }
        return \count((array) $funcCall->args) >= 1;
    }
    /**
     * @return PropertyFetch|MethodCall|null
     */
    private function createMethodCallArrayFunctionToMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ArrayFuncCallToMethodCall $arrayFuncCallToMethodCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($funcCall->args === []) {
            return $propertyFetch;
        }
        if ($arrayFuncCallToMethodCall->getArrayMethod() && $this->isArrayType($funcCall->args[0]->value)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, $arrayFuncCallToMethodCall->getArrayMethod(), $funcCall->args);
        }
        if ($arrayFuncCallToMethodCall->getNonArrayMethod() && !$this->isArrayType($funcCall->args[0]->value)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, $arrayFuncCallToMethodCall->getNonArrayMethod(), $funcCall->args);
        }
        return null;
    }
}
