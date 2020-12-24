<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertComparisonToSpecificMethodRector\AssertComparisonToSpecificMethodRectorTest
 */
final class AssertComparisonToSpecificMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var BinaryOpWithAssertMethod[]
     */
    private $binaryOpWithAssertMethods = [];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
        $this->binaryOpWithAssertMethods = [new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class, 'assertSame', 'assertNotSame'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, 'assertNotSame', 'assertSame'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal::class, 'assertEquals', 'assertNotEquals'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual::class, 'assertNotEquals', 'assertEquals'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater::class, 'assertGreaterThan', 'assertLessThan'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller::class, 'assertLessThan', 'assertGreaterThan'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, 'assertGreaterThanOrEqual', 'assertLessThanOrEqual'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, 'assertLessThanOrEqual', 'assertGreaterThanOrEqual')];
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns comparison operations to their method name alternatives in PHPUnit TestCase', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertTrue($foo === $bar, "message");', '$this->assertSame($bar, $foo, "message");'), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse($foo >= $bar, "message");', '$this->assertLessThanOrEqual($bar, $foo, "message");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertTrue', 'assertFalse'])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        return $this->processCallWithBinaryOp($node, $firstArgumentValue);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function processCallWithBinaryOp(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->binaryOpWithAssertMethods as $binaryOpWithAssertMethod) {
            if (\get_class($binaryOp) !== $binaryOpWithAssertMethod->getBinaryOpClass()) {
                continue;
            }
            $this->identifierManipulator->renameNodeWithMap($node, ['assertTrue' => $binaryOpWithAssertMethod->getAssetMethodName(), 'assertFalse' => $binaryOpWithAssertMethod->getNotAssertMethodName()]);
            $this->changeArgumentsOrder($node);
            return $node;
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function changeArgumentsOrder(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $oldArguments = $node->args;
        /** @var BinaryOp $expression */
        $expression = $oldArguments[0]->value;
        if ($this->isConstantValue($expression->left)) {
            $firstArgument = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($expression->left);
            $secondArgument = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($expression->right);
        } else {
            $firstArgument = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($expression->right);
            $secondArgument = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($expression->left);
        }
        unset($oldArguments[0]);
        $newArgs = [$firstArgument, $secondArgument];
        $node->args = $this->appendArgs($newArgs, $oldArguments);
    }
    private function isConstantValue(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        $nodeClass = \get_class($expr);
        if (\in_array($nodeClass, [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch::class], \true)) {
            return \true;
        }
        if (\is_subclass_of($expr, \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar::class)) {
            return \true;
        }
        return $this->isVariableName($expr, 'exp*');
    }
}
