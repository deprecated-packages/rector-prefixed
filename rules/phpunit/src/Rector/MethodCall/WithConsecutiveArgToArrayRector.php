<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use ReflectionMethod;
use _PhpScoper2a4e7ab1ecbc\Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/10954107/phpunit-how-do-i-mock-multiple-method-calls-with-multiple-arguments/28045531#28045531
 * @see https://github.com/sebastianbergmann/phpunit/commit/72098d80f0cfc06c7e0652d331602685ce5b4b51
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\WithConsecutiveArgToArrayRectorTest
 */
final class WithConsecutiveArgToArrayRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodCallManipulator
     */
    private $methodCallManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator $methodCallManipulator)
    {
        $this->methodCallManipulator = $methodCallManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split withConsecutive() arg to array', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($one, $two)
    {
    }
}

class SomeTestCase extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $someClassMock = $this->createMock(SomeClass::class);
        $someClassMock
            ->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive(1, 2, 3, 5);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($one, $two)
    {
    }
}

class SomeTestCase extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $someClassMock = $this->createMock(SomeClass::class);
        $someClassMock
            ->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive([1, 2], [3, 5]);
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isName($node->name, 'withConsecutive')) {
            return null;
        }
        if ($this->areAllArgArrayTypes($node)) {
            return null;
        }
        // is a mock?
        if (!$this->isObjectType($node, '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\Builder\\InvocationMocker')) {
            return null;
        }
        $mockClass = $this->inferMockedClassName($node);
        if ($mockClass === null) {
            return null;
        }
        $mockMethod = $this->inferMockedMethodName($node);
        $reflectionMethod = new \ReflectionMethod($mockClass, $mockMethod);
        $numberOfParameters = $reflectionMethod->getNumberOfParameters();
        $values = [];
        foreach ($node->args as $arg) {
            $values[] = $arg->value;
        }
        // simple check argument count fits to method required args
        if (\count($values) % $numberOfParameters !== 0) {
            return null;
        }
        $node->args = [];
        // split into chunks of X parameters
        $valueChunks = \array_chunk($values, $numberOfParameters);
        foreach ($valueChunks as $valueChunk) {
            $node->args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($this->createArray($valueChunk));
        }
        return $node;
    }
    private function areAllArgArrayTypes(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        foreach ($methodCall->args as $arg) {
            $argumentStaticType = $this->getStaticType($arg->value);
            if ($argumentStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    private function inferMockedClassName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $variable = $this->findRootVariableOfChainCall($methodCall);
        if ($variable === null) {
            return null;
        }
        // look for "$this->createMock(X)"
        $assignToVariable = $this->methodCallManipulator->findAssignToVariable($variable);
        if ($assignToVariable === null) {
            return null;
        }
        if ($assignToVariable->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            /** @var MethodCall $assignedMethodCall */
            $assignedMethodCall = $assignToVariable->expr;
            if ($this->isName($assignedMethodCall->var, 'this') && $this->isName($assignedMethodCall->name, 'createMock')) {
                $firstArgumentValue = $assignedMethodCall->args[0]->value;
                return $this->getValue($firstArgumentValue);
            }
        }
        return null;
    }
    private function inferMockedMethodName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $previousMethodCalls = $this->methodCallManipulator->findMethodCallsIncludingChain($methodCall);
        foreach ($previousMethodCalls as $previousMethodCall) {
            if (!$this->isName($previousMethodCall->name, 'method')) {
                continue;
            }
            $firstArgumentValue = $previousMethodCall->args[0]->value;
            if (!$firstArgumentValue instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
                continue;
            }
            return $firstArgumentValue->value;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
    }
    private function findRootVariableOfChainCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
    {
        $currentMethodCallee = $methodCall->var;
        while (!$currentMethodCallee instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            $currentMethodCallee = $currentMethodCallee->var;
        }
        return $currentMethodCallee;
    }
}
