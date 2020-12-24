<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use ReflectionMethod;
use _PhpScoperb75b35f52b74\Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/10954107/phpunit-how-do-i-mock-multiple-method-calls-with-multiple-arguments/28045531#28045531
 * @see https://github.com/sebastianbergmann/phpunit/commit/72098d80f0cfc06c7e0652d331602685ce5b4b51
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\WithConsecutiveArgToArrayRector\WithConsecutiveArgToArrayRectorTest
 */
final class WithConsecutiveArgToArrayRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodCallManipulator
     */
    private $methodCallManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator $methodCallManipulator)
    {
        $this->methodCallManipulator = $methodCallManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split withConsecutive() arg to array', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node->name, 'withConsecutive')) {
            return null;
        }
        if ($this->areAllArgArrayTypes($node)) {
            return null;
        }
        // is a mock?
        if (!$this->isObjectType($node, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Builder\\InvocationMocker')) {
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
            $node->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($this->createArray($valueChunk));
        }
        return $node;
    }
    private function areAllArgArrayTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        foreach ($methodCall->args as $arg) {
            $argumentStaticType = $this->getStaticType($arg->value);
            if ($argumentStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    private function inferMockedClassName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
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
        if ($assignToVariable->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            /** @var MethodCall $assignedMethodCall */
            $assignedMethodCall = $assignToVariable->expr;
            if ($this->isName($assignedMethodCall->var, 'this') && $this->isName($assignedMethodCall->name, 'createMock')) {
                $firstArgumentValue = $assignedMethodCall->args[0]->value;
                return $this->getValue($firstArgumentValue);
            }
        }
        return null;
    }
    private function inferMockedMethodName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $previousMethodCalls = $this->methodCallManipulator->findMethodCallsIncludingChain($methodCall);
        foreach ($previousMethodCalls as $previousMethodCall) {
            if (!$this->isName($previousMethodCall->name, 'method')) {
                continue;
            }
            $firstArgumentValue = $previousMethodCall->args[0]->value;
            if (!$firstArgumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
                continue;
            }
            return $firstArgumentValue->value;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
    private function findRootVariableOfChainCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        $currentMethodCallee = $methodCall->var;
        while (!$currentMethodCallee instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            $currentMethodCallee = $currentMethodCallee->var;
        }
        return $currentMethodCallee;
    }
}
