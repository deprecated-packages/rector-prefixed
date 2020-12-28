<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use Rector\Core\Rector\AbstractPHPUnitRector;
use Rector\PHPUnit\ValueObject\ConstantWithAssertMethods;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector\AssertSameBoolNullToSpecificMethodRectorTest
 */
final class AssertSameBoolNullToSpecificMethodRector extends \Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var ConstantWithAssertMethods[]
     */
    private $constantWithAssertMethods = [];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
        $this->constantWithAssertMethods = [new \Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('null', 'assertNull', 'assertNotNull'), new \Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('true', 'assertTrue', 'assertNotTrue'), new \Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('false', 'assertFalse', 'assertNotFalse')];
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns same bool and null comparisons to their method name alternatives in PHPUnit TestCase', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertSame(null, $anything);', '$this->assertNull($anything);'), new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertNotSame(false, $anything);', '$this->assertNotFalse($anything);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertSame', 'assertNotSame'])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if (!$firstArgumentValue instanceof \PhpParser\Node\Expr\ConstFetch) {
            return null;
        }
        foreach ($this->constantWithAssertMethods as $constantWithAssertMethod) {
            if (!$this->isName($firstArgumentValue, $constantWithAssertMethod->getConstant())) {
                continue;
            }
            $this->renameMethod($node, $constantWithAssertMethod);
            $this->moveArguments($node);
            return $node;
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function renameMethod(\PhpParser\Node $node, \Rector\PHPUnit\ValueObject\ConstantWithAssertMethods $constantWithAssertMethods) : void
    {
        $this->identifierManipulator->renameNodeWithMap($node, ['assertSame' => $constantWithAssertMethods->getAssetMethodName(), 'assertNotSame' => $constantWithAssertMethods->getNotAssertMethodName()]);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function moveArguments(\PhpParser\Node $node) : void
    {
        $methodArguments = $node->args;
        \array_shift($methodArguments);
        $node->args = $methodArguments;
    }
}
