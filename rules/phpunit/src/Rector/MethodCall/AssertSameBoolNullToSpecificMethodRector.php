<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ConstantWithAssertMethods;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector\AssertSameBoolNullToSpecificMethodRectorTest
 */
final class AssertSameBoolNullToSpecificMethodRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var ConstantWithAssertMethods[]
     */
    private $constantWithAssertMethods = [];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
        $this->constantWithAssertMethods = [new \_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('null', 'assertNull', 'assertNotNull'), new \_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('true', 'assertTrue', 'assertNotTrue'), new \_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ConstantWithAssertMethods('false', 'assertFalse', 'assertNotFalse')];
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns same bool and null comparisons to their method name alternatives in PHPUnit TestCase', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertSame(null, $anything);', '$this->assertNull($anything);'), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertNotSame(false, $anything);', '$this->assertNotFalse($anything);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertSame', 'assertNotSame'])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch) {
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
    private function renameMethod(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ConstantWithAssertMethods $constantWithAssertMethods) : void
    {
        $this->identifierManipulator->renameNodeWithMap($node, ['assertSame' => $constantWithAssertMethods->getAssetMethodName(), 'assertNotSame' => $constantWithAssertMethods->getNotAssertMethodName()]);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function moveArguments(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $methodArguments = $node->args;
        \array_shift($methodArguments);
        $node->args = $methodArguments;
    }
}
