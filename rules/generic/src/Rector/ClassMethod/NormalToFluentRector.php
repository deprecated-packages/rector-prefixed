<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\NormalToFluent;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\NormalToFluentRector\NormalToFluentRectorTest
 */
final class NormalToFluentRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CALLS_TO_FLUENT = 'calls_to_fluent';
    /**
     * @var NormalToFluent[]
     */
    private $callsToFluent = [];
    /**
     * @var MethodCall[]
     */
    private $collectedMethodCalls = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fluent interface calls to classic ones.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass();
$someObject->someFunction();
$someObject->otherFunction();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass();
$someObject->someFunction()
    ->otherFunction();
CODE_SAMPLE
, [self::CALLS_TO_FLUENT => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\NormalToFluent('SomeClass', ['someFunction', 'otherFunction'])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        // process only existing statements
        if ($node->stmts === null) {
            return null;
        }
        $classMethodStatementCount = \count((array) $node->stmts);
        // iterate from bottom to up, so we can merge
        for ($i = $classMethodStatementCount - 1; $i >= 0; --$i) {
            /** @var Expression $stmt */
            $stmt = $node->stmts[$i];
            if ($this->shouldSkipPreviousStmt($node, $i, $stmt)) {
                continue;
            }
            /** @var Expression $prevStmt */
            $prevStmt = $node->stmts[$i - 1];
            // here are 2 method calls statements in a row, while current one is first one
            if (!$this->isBothMethodCallMatch($stmt, $prevStmt)) {
                if (\count($this->collectedMethodCalls) >= 2) {
                    $this->fluentizeCollectedMethodCalls($node);
                }
                // reset for new type
                $this->collectedMethodCalls = [];
                continue;
            }
            // add all matching fluent calls
            /** @var MethodCall $currentMethodCall */
            $currentMethodCall = $stmt->expr;
            $this->collectedMethodCalls[$i] = $currentMethodCall;
            /** @var MethodCall $previousMethodCall */
            $previousMethodCall = $prevStmt->expr;
            $this->collectedMethodCalls[$i - 1] = $previousMethodCall;
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $callsToFluent = $configuration[self::CALLS_TO_FLUENT] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($callsToFluent, \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\NormalToFluent::class);
        $this->callsToFluent = $callsToFluent;
    }
    private function shouldSkipPreviousStmt(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, int $i, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression) : bool
    {
        // we look only for 2+ stmts
        if (!isset($classMethod->stmts[$i - 1])) {
            return \true;
        }
        // we look for 2 methods calls in a row
        if (!$expression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \true;
        }
        $prevStmt = $classMethod->stmts[$i - 1];
        return !$prevStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
    }
    private function isBothMethodCallMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $firstExpression, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $secondExpression) : bool
    {
        if (!$firstExpression->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$secondExpression->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $firstMethodCallMatch = $this->matchMethodCall($firstExpression->expr);
        if ($firstMethodCallMatch === null) {
            return \false;
        }
        $secondMethodCallMatch = $this->matchMethodCall($secondExpression->expr);
        if ($secondMethodCallMatch === null) {
            return \false;
        }
        // is the same type
        return $firstMethodCallMatch === $secondMethodCallMatch;
    }
    private function fluentizeCollectedMethodCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $i = 0;
        $fluentMethodCallIndex = null;
        $methodCallsToAdd = [];
        foreach ($this->collectedMethodCalls as $statementIndex => $methodCall) {
            if ($i === 0) {
                // first method call, add it
                $fluentMethodCallIndex = $statementIndex;
            } else {
                $methodCallsToAdd[] = $methodCall;
                // next method calls, unset them
                unset($classMethod->stmts[$statementIndex]);
            }
            ++$i;
        }
        $stmt = $classMethod->stmts[$fluentMethodCallIndex];
        if (!$stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        /** @var MethodCall $fluentMethodCall */
        $fluentMethodCall = $stmt->expr;
        // they are added in reversed direction
        $methodCallsToAdd = \array_reverse($methodCallsToAdd);
        foreach ($methodCallsToAdd as $methodCallToAdd) {
            // make var a parent method call
            $fluentMethodCall->var = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($fluentMethodCall->var, $methodCallToAdd->name, $methodCallToAdd->args);
        }
    }
    private function matchMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        foreach ($this->callsToFluent as $callToFluent) {
            if (!$this->isObjectType($methodCall, $callToFluent->getClass())) {
                continue;
            }
            if ($this->isNames($methodCall->name, $callToFluent->getMethodNames())) {
                return $callToFluent->getClass();
            }
        }
        return null;
    }
}
