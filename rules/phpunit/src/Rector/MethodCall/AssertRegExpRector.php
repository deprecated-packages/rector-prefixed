<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertRegExpRector\AssertRegExpRectorTest
 */
final class AssertRegExpRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string
     */
    private const ASSERT_SAME = 'assertSame';
    /**
     * @var string
     */
    private const ASSERT_EQUALS = 'assertEquals';
    /**
     * @var string
     */
    private const ASSERT_NOT_SAME = 'assertNotSame';
    /**
     * @var string
     */
    private const ASSERT_NOT_EQUALS = 'assertNotEquals';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `preg_match` comparisons to their method name alternatives in PHPUnit TestCase', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertSame(1, preg_match("/^Message for ".*"\\.$/", $string), $message);', '$this->assertRegExp("/^Message for ".*"\\.$/", $string, $message);'), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertEquals(false, preg_match("/^Message for ".*"\\.$/", $string), $message);', '$this->assertNotRegExp("/^Message for ".*"\\.$/", $string, $message);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, [self::ASSERT_SAME, self::ASSERT_EQUALS, self::ASSERT_NOT_SAME, self::ASSERT_NOT_EQUALS])) {
            return null;
        }
        /** @var FuncCall|Node $secondArgumentValue */
        $secondArgumentValue = $node->args[1]->value;
        if (!$secondArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if (!$this->isName($secondArgumentValue, 'preg_match')) {
            return null;
        }
        $oldMethodName = $this->getName($node->name);
        if ($oldMethodName === null) {
            return null;
        }
        $oldFirstArgument = $node->args[0]->value;
        $oldCondition = $this->resolveOldCondition($oldFirstArgument);
        $this->renameMethod($node, $oldMethodName, $oldCondition);
        $this->moveFunctionArgumentsUp($node);
        return $node;
    }
    private function resolveOldCondition(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : int
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            return $expr->value;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return $this->isTrue($expr) ? 1 : 0;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function renameMethod(\_PhpScopere8e811afab72\PhpParser\Node $node, string $oldMethodName, int $oldCondition) : void
    {
        if (\in_array($oldMethodName, [self::ASSERT_SAME, self::ASSERT_EQUALS], \true) && $oldCondition === 1 || \in_array($oldMethodName, [self::ASSERT_NOT_SAME, self::ASSERT_NOT_EQUALS], \true) && $oldCondition === 0) {
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('assertRegExp');
        }
        if (\in_array($oldMethodName, [self::ASSERT_SAME, self::ASSERT_EQUALS], \true) && $oldCondition === 0 || \in_array($oldMethodName, [self::ASSERT_NOT_SAME, self::ASSERT_NOT_EQUALS], \true) && $oldCondition === 1) {
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('assertNotRegExp');
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function moveFunctionArgumentsUp(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $oldArguments = $node->args;
        /** @var FuncCall $pregMatchFunction */
        $pregMatchFunction = $oldArguments[1]->value;
        $regex = $pregMatchFunction->args[0];
        $variable = $pregMatchFunction->args[1];
        unset($oldArguments[0], $oldArguments[1]);
        $node->args = \array_merge([$regex, $variable], $oldArguments);
    }
}
