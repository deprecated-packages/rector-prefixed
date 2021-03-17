<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BinaryOp\Smaller;
use PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Scalar;
use Rector\Core\Rector\AbstractRector;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod;
use Rector\Renaming\NodeManipulator\IdentifierManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector\AssertComparisonToSpecificMethodRectorTest
 */
final class AssertComparisonToSpecificMethodRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpWithAssertMethod[]
     */
    private $binaryOpWithAssertMethods = [];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    /**
     * @param \Rector\Renaming\NodeManipulator\IdentifierManipulator $identifierManipulator
     * @param \Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer
     */
    public function __construct($identifierManipulator, $testsNodeAnalyzer)
    {
        $this->identifierManipulator = $identifierManipulator;
        $this->binaryOpWithAssertMethods = [new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\Identical::class, 'assertSame', 'assertNotSame'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, 'assertNotSame', 'assertSame'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\Equal::class, 'assertEquals', 'assertNotEquals'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\NotEqual::class, 'assertNotEquals', 'assertEquals'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\Greater::class, 'assertGreaterThan', 'assertLessThan'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\Smaller::class, 'assertLessThan', 'assertGreaterThan'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, 'assertGreaterThanOrEqual', 'assertLessThanOrEqual'), new \Rector\PHPUnit\ValueObject\BinaryOpWithAssertMethod(\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, 'assertLessThanOrEqual', 'assertGreaterThanOrEqual')];
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns comparison operations to their method name alternatives in PHPUnit TestCase', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertTrue($foo === $bar, "message");', '$this->assertSame($bar, $foo, "message");'), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse($foo >= $bar, "message");', '$this->assertLessThanOrEqual($bar, $foo, "message");')]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if (!$this->testsNodeAnalyzer->isPHPUnitMethodNames($node, ['assertTrue', 'assertFalse'])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if (!$firstArgumentValue instanceof \PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        return $this->processCallWithBinaryOp($node, $firstArgumentValue);
    }
    /**
     * @param MethodCall|StaticCall $node
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOp
     */
    private function processCallWithBinaryOp($node, $binaryOp) : ?\PhpParser\Node
    {
        $binaryOpClass = \get_class($binaryOp);
        foreach ($this->binaryOpWithAssertMethods as $binaryOpWithAssertMethod) {
            if ($binaryOpClass !== $binaryOpWithAssertMethod->getBinaryOpClass()) {
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
    private function changeArgumentsOrder($node) : void
    {
        $oldArguments = $node->args;
        /** @var BinaryOp $expression */
        $expression = $oldArguments[0]->value;
        if ($this->isConstantValue($expression->left)) {
            $firstArgument = new \PhpParser\Node\Arg($expression->left);
            $secondArgument = new \PhpParser\Node\Arg($expression->right);
        } else {
            $firstArgument = new \PhpParser\Node\Arg($expression->right);
            $secondArgument = new \PhpParser\Node\Arg($expression->left);
        }
        unset($oldArguments[0]);
        $newArgs = [$firstArgument, $secondArgument];
        $node->args = $this->appendArgs($newArgs, $oldArguments);
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     */
    private function isConstantValue($expr) : bool
    {
        $nodeClass = \get_class($expr);
        if (\in_array($nodeClass, [\PhpParser\Node\Expr\Array_::class, \PhpParser\Node\Expr\ConstFetch::class], \true)) {
            return \true;
        }
        if (\is_subclass_of($expr, \PhpParser\Node\Scalar::class)) {
            return \true;
        }
        return $this->nodeNameResolver->isVariableName($expr, 'exp*');
    }
}
