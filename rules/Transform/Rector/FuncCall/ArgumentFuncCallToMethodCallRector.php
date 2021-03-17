<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Naming\PropertyNaming;
use Rector\Naming\ValueObject\ExpectedName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210317\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector\ArgumentFuncCallToMethodCallRectorTest
 */
final class ArgumentFuncCallToMethodCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    /**
     * @var ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    public function __construct(\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move help facade-like function calls to constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::FUNCTIONS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', 'Illuminate\\Contracts\\View\\Factory', 'make')]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if ($this->shouldSkipFuncCall($node)) {
            return null;
        }
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        foreach ($this->argumentFuncCallToMethodCalls as $functionToMethodCall) {
            if (!$this->isName($node, $functionToMethodCall->getFunction())) {
                continue;
            }
            return $this->refactorFuncCallToMethodCall($functionToMethodCall, $classLike, $node);
        }
        foreach ($this->arrayFunctionsToMethodCalls as $arrayFunctionToMethodCall) {
            if (!$this->isName($node, $arrayFunctionToMethodCall->getFunction())) {
                continue;
            }
            return $this->refactorArrayFunctionToMethodCall($arrayFunctionToMethodCall, $node, $classLike);
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure($configuration) : void
    {
        $functionToMethodCalls = $configuration[self::FUNCTIONS_TO_METHOD_CALLS] ?? [];
        \RectorPrefix20210317\Webmozart\Assert\Assert::allIsInstanceOf($functionToMethodCalls, \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall::class);
        $this->argumentFuncCallToMethodCalls = $functionToMethodCalls;
        $arrayFunctionsToMethodCalls = $configuration[self::ARRAY_FUNCTIONS_TO_METHOD_CALLS] ?? [];
        \RectorPrefix20210317\Webmozart\Assert\Assert::allIsInstanceOf($arrayFunctionsToMethodCalls, \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall::class);
        $this->arrayFunctionsToMethodCalls = $arrayFunctionsToMethodCalls;
    }
    /**
     * @param \PhpParser\Node\Expr\FuncCall $funcCall
     */
    private function shouldSkipFuncCall($funcCall) : bool
    {
        // we can inject only in injectable class method  context
        // we can inject only in injectable class method  context
        /** @var ClassMethod|null $classMethod */
        $classMethod = $funcCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \true;
        }
        return $classMethod->isStatic();
    }
    /**
     * @return PropertyFetch|MethodCall
     * @param \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param \PhpParser\Node\Expr\FuncCall $funcCall
     */
    private function refactorFuncCallToMethodCall($argumentFuncCallToMethodCall, $class, $funcCall) : ?\PhpParser\Node
    {
        $fullyQualifiedObjectType = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($argumentFuncCallToMethodCall->getClass());
        $expectedName = $this->propertyNaming->getExpectedNameFromType($fullyQualifiedObjectType);
        if (!$expectedName instanceof \Rector\Naming\ValueObject\ExpectedName) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $expectedName->getName());
        $propertyFetchNode = $this->nodeFactory->createPropertyFetch('this', $expectedName->getName());
        if ($funcCall->args === []) {
            return $this->refactorEmptyFuncCallArgs($argumentFuncCallToMethodCall, $propertyFetchNode);
        }
        if ($this->isFunctionToMethodCallWithArgs($funcCall, $argumentFuncCallToMethodCall)) {
            $methodName = $argumentFuncCallToMethodCall->getMethodIfArgs();
            if (!\is_string($methodName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \PhpParser\Node\Expr\MethodCall($propertyFetchNode, $methodName, $funcCall->args);
        }
        return null;
    }
    /**
     * @return PropertyFetch|MethodCall|null
     * @param \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall $arrayFuncCallToMethodCall
     * @param \PhpParser\Node\Expr\FuncCall $funcCall
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function refactorArrayFunctionToMethodCall($arrayFuncCallToMethodCall, $funcCall, $class) : ?\PhpParser\Node
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($arrayFuncCallToMethodCall->getClass());
        $propertyFetch = $this->nodeFactory->createPropertyFetch('this', $propertyName);
        $fullyQualifiedObjectType = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($arrayFuncCallToMethodCall->getClass());
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $propertyName);
        return $this->createMethodCallArrayFunctionToMethodCall($funcCall, $arrayFuncCallToMethodCall, $propertyFetch);
    }
    /**
     * @return PropertyFetch|MethodCall
     * @param \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall
     * @param \PhpParser\Node\Expr\PropertyFetch $propertyFetch
     */
    private function refactorEmptyFuncCallArgs($argumentFuncCallToMethodCall, $propertyFetch) : \PhpParser\Node
    {
        if ($argumentFuncCallToMethodCall->getMethodIfNoArgs()) {
            $methodName = $argumentFuncCallToMethodCall->getMethodIfNoArgs();
            if (!\is_string($methodName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \PhpParser\Node\Expr\MethodCall($propertyFetch, $methodName);
        }
        return $propertyFetch;
    }
    /**
     * @param \PhpParser\Node\Expr\FuncCall $funcCall
     * @param \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall $argumentFuncCallToMethodCall
     */
    private function isFunctionToMethodCallWithArgs($funcCall, $argumentFuncCallToMethodCall) : bool
    {
        if ($argumentFuncCallToMethodCall->getMethodIfArgs() === null) {
            return \false;
        }
        return \count($funcCall->args) >= 1;
    }
    /**
     * @return PropertyFetch|MethodCall|null
     * @param \PhpParser\Node\Expr\FuncCall $funcCall
     * @param \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall $arrayFuncCallToMethodCall
     * @param \PhpParser\Node\Expr\PropertyFetch $propertyFetch
     */
    private function createMethodCallArrayFunctionToMethodCall($funcCall, $arrayFuncCallToMethodCall, $propertyFetch) : ?\PhpParser\Node
    {
        if ($funcCall->args === []) {
            return $propertyFetch;
        }
        if ($arrayFuncCallToMethodCall->getArrayMethod() && $this->arrayTypeAnalyzer->isArrayType($funcCall->args[0]->value)) {
            return new \PhpParser\Node\Expr\MethodCall($propertyFetch, $arrayFuncCallToMethodCall->getArrayMethod(), $funcCall->args);
        }
        if ($arrayFuncCallToMethodCall->getNonArrayMethod() === '') {
            return null;
        }
        if ($this->arrayTypeAnalyzer->isArrayType($funcCall->args[0]->value)) {
            return null;
        }
        return new \PhpParser\Node\Expr\MethodCall($propertyFetch, $arrayFuncCallToMethodCall->getNonArrayMethod(), $funcCall->args);
    }
}
