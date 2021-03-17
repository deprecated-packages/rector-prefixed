<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeAnalyzer;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Expression;
use Rector\PHPUnit\NodeFactory\ConsecutiveAssertionFactory;
use Rector\PHPUnit\ValueObject\ExpectationMock;
use Rector\PHPUnit\ValueObject\ExpectationMockCollection;
final class ExpectationAnalyzer
{
    private const PROCESSABLE_WILL_STATEMENTS = ['will', 'willReturn', 'willReturnReference', 'willReturnMap', 'willReturnArgument', 'willReturnCallback', 'willReturnSelf', 'willThrowException'];
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    /**
     * @var ConsecutiveAssertionFactory
     */
    private $consecutiveAssertionFactory;
    public function __construct(\Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer, \Rector\PHPUnit\NodeFactory\ConsecutiveAssertionFactory $consecutiveAssertionFactory)
    {
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
        $this->consecutiveAssertionFactory = $consecutiveAssertionFactory;
    }
    /**
     * @param Expression[] $stmts
     */
    public function getExpectationsFromExpressions(array $stmts) : \Rector\PHPUnit\ValueObject\ExpectationMockCollection
    {
        $expectationMockCollection = new \Rector\PHPUnit\ValueObject\ExpectationMockCollection();
        foreach ($stmts as $stmt) {
            /** @var MethodCall $expr */
            $expr = $stmt->expr;
            $method = $this->getMethod($expr);
            if (!$this->testsNodeAnalyzer->isPHPUnitMethodName($method, 'method')) {
                continue;
            }
            /** @var MethodCall $expects */
            $expects = $this->getExpects($method->var, $method);
            if (!$this->isValidExpectsCall($expects)) {
                continue;
            }
            $expectsArg = $expects->args[0];
            /** @var MethodCall $expectsValue */
            $expectsValue = $expectsArg->value;
            if (!$this->isValidAtCall($expectsValue)) {
                continue;
            }
            $atArg = $expectsValue->args[0];
            $atValue = $atArg->value;
            if ($atValue instanceof \PhpParser\Node\Scalar\LNumber && $expects->var instanceof \PhpParser\Node\Expr\Variable) {
                $expectationMockCollection->add(new \Rector\PHPUnit\ValueObject\ExpectationMock($expects->var, $method->args, $atValue->value, $this->getWill($expr), $this->getWithArgs($method->var), $stmt));
            }
        }
        return $expectationMockCollection;
    }
    private function getMethod(\PhpParser\Node\Expr\MethodCall $expr) : \PhpParser\Node\Expr\MethodCall
    {
        if ($this->testsNodeAnalyzer->isPHPUnitMethodNames($expr, self::PROCESSABLE_WILL_STATEMENTS) && $expr->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return $expr->var;
        }
        return $expr;
    }
    private function getWill(\PhpParser\Node\Expr\MethodCall $expr) : ?\PhpParser\Node\Expr
    {
        if (!$this->testsNodeAnalyzer->isPHPUnitMethodNames($expr, self::PROCESSABLE_WILL_STATEMENTS)) {
            return null;
        }
        return $this->consecutiveAssertionFactory->createWillReturn($expr);
    }
    private function getExpects(\PhpParser\Node\Expr $maybeWith, \PhpParser\Node\Expr\MethodCall $method) : \PhpParser\Node\Expr
    {
        if ($this->testsNodeAnalyzer->isPHPUnitMethodName($maybeWith, 'with') && $maybeWith instanceof \PhpParser\Node\Expr\MethodCall) {
            return $maybeWith->var;
        }
        return $method->var;
    }
    /**
     * @return array<int, Expr|null>
     */
    private function getWithArgs(\PhpParser\Node\Expr $maybeWith) : array
    {
        if ($this->testsNodeAnalyzer->isPHPUnitMethodName($maybeWith, 'with') && $maybeWith instanceof \PhpParser\Node\Expr\MethodCall) {
            return \array_map(static function (\PhpParser\Node\Arg $arg) {
                return $arg->value;
            }, $maybeWith->args);
        }
        return [null];
    }
    public function isValidExpectsCall(\PhpParser\Node\Expr\MethodCall $expr) : bool
    {
        if (!$this->testsNodeAnalyzer->isPHPUnitMethodName($expr, 'expects')) {
            return \false;
        }
        if (\count($expr->args) !== 1) {
            return \false;
        }
        return \true;
    }
    public function isValidAtCall(\PhpParser\Node\Expr\MethodCall $expr) : bool
    {
        if (!$this->testsNodeAnalyzer->isPHPUnitMethodName($expr, 'at')) {
            return \false;
        }
        if (\count($expr->args) !== 1) {
            return \false;
        }
        return \true;
    }
}
