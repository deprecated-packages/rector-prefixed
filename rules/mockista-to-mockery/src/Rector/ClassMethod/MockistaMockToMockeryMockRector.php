<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use _PhpScoperb75b35f52b74\Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockistaToMockery\Tests\Rector\ClassMethod\MockistaMockToMockeryMockRector\MockistaMockToMockeryMockRectorTest
 */
final class MockistaMockToMockeryMockRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string[]
     */
    private const METHODS_TO_REMOVE = ['freeze', 'assertExpectations'];
    /**
     * @var string[]
     */
    private $mockVariableTypesByNames = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change functions to static calls, so composer can autoload them', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeTest
{
    public function run()
    {
        $mockUser = mock(User::class);
        $mockUser->getId()->once->andReturn(1);
        $mockUser->freeze();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeTest
{
    public function run()
    {
        $mockUser = Mockery::mock(User::class);
        $mockUser->expects()->getId()->once()->andReturn(1);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $this->replaceMockWithMockerMockAndCollectMockVariableName($node);
        $this->replaceMethodCallOncePropertyFetch($node);
        $this->removeUnusedMethodCalls($node);
        $this->replaceMethodCallWithExpects($node);
        $this->switchWithAnyArgsAndOnceTwice($node);
        return $node;
    }
    private function replaceMockWithMockerMockAndCollectMockVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?StaticCall {
            if (!$this->isFuncCallName($node, 'mock')) {
                return null;
            }
            /** @var FuncCall $node */
            $this->collectMockVariableName($node);
            return $this->createStaticCall('Mockery', 'mock', $node->args);
        });
    }
    /**
     * $mock->getMethod()->once
     * ↓
     * $mock->getMethod()->once()
     */
    private function replaceMethodCallOncePropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?MethodCall {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->isNames($node->name, ['once', 'twice'])) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($node->var, $node->name);
        });
    }
    private function removeUnusedMethodCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) {
            if (!$this->isMethodCallOrPropertyFetchOnMockVariable($node)) {
                return null;
            }
            /** @var PropertyFetch|MethodCall $node */
            if (!$this->isNames($node->name, self::METHODS_TO_REMOVE)) {
                return null;
            }
            $this->removeNode($node);
        });
    }
    /**
     * $mock->getMethod()->once()
     * ↓
     * $mock->expects()->getMethod()->once()
     */
    private function replaceMethodCallWithExpects(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?MethodCall {
            if (!$this->isMethodCallOrPropertyFetchOnMockVariable($node)) {
                return null;
            }
            // skip assigns
            $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            /** @var MethodCall|PropertyFetch $node */
            if ($this->isNames($node->name, self::METHODS_TO_REMOVE)) {
                return null;
            }
            if ($this->isNames($node->name, ['expects', 'allows'])) {
                return null;
            }
            // probably method mock
            $expectedMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($node->var, 'expects');
            $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($expectedMethodCall, $node->name);
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return $methodCall;
            }
            $methodCall->args = $node->args;
            return $this->decorateWithAnyArgs($node, $methodCall);
        });
    }
    /**
     * Order correction for @see replaceMethodCallWithExpects()
     */
    private function switchWithAnyArgsAndOnceTwice(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isNames($node->name, ['once', 'twice'])) {
                return;
            }
            if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            /** @var MethodCall $previousMethodCall */
            $previousMethodCall = $node->var;
            if (!$this->isName($previousMethodCall->name, 'withAnyArgs')) {
                return null;
            }
            [$node->name, $previousMethodCall->name] = [$previousMethodCall->name, $node->name];
        });
    }
    private function collectMockVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : void
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return;
        }
        if (!$parentNode->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return;
        }
        /** @var Variable $variable */
        $variable = $parentNode->var;
        /** @var string $variableName */
        $variableName = $this->getName($variable);
        $type = $funcCall->args[0]->value;
        $mockedType = $this->getValue($type);
        $this->mockVariableTypesByNames[$variableName] = $mockedType;
    }
    private function isMethodCallOrPropertyFetchOnMockVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall && !$this->isPropertyFetchDisguisedAsMethodCall($node)) {
            return \false;
        }
        /** @var MethodCall|PropertyFetch $node */
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        /** @var string $variableName */
        $variableName = $this->getName($node->var);
        return isset($this->mockVariableTypesByNames[$variableName]);
    }
    /**
     * $mock->someMethodWithArgs()->once()
     * ↓
     * $mock->expects()->someMethodWithArgs()->withAnyArgs()->once()
     */
    private function decorateWithAnyArgs(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $originalMethodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $expectsMethodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $variableName = $this->getName($originalMethodCall->var);
        $mockVariableType = $this->mockVariableTypesByNames[$variableName];
        $methodName = $this->getName($originalMethodCall->name);
        if ($methodName === null) {
            return $expectsMethodCall;
        }
        if (!\method_exists($mockVariableType, $methodName)) {
            return $expectsMethodCall;
        }
        $reflectionMethod = new \ReflectionMethod($mockVariableType, $methodName);
        if ($reflectionMethod->getNumberOfRequiredParameters() === 0) {
            return $expectsMethodCall;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($expectsMethodCall, 'withAnyArgs');
    }
    private function isPropertyFetchDisguisedAsMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $variableName = $this->getName($node->var);
        if (!isset($this->mockVariableTypesByNames[$variableName])) {
            return \false;
        }
        $mockVariableType = $this->mockVariableTypesByNames[$variableName];
        $propertyName = $this->getName($node->name);
        if ($propertyName === null) {
            return \false;
        }
        return \method_exists($mockVariableType, $propertyName);
    }
}
