<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/3388
 * @see https://github.com/sebastianbergmann/phpunit/commit/34a0abd8b56a4a9de83c9e56384f462541a0f939
 *
 * @see https://github.com/sebastianbergmann/phpunit/tree/master/src/Runner/Hook
 * @see \Rector\PHPUnit\Tests\Rector\Class_\TestListenerToHooksRector\TestListenerToHooksRectorTest
 */
final class TestListenerToHooksRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[][]
     */
    private const LISTENER_METHOD_TO_HOOK_INTERFACES = [
        'addIncompleteTest' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterIncompleteTestHook', 'executeAfterIncompleteTest'],
        'addRiskyTest' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterRiskyTestHook', 'executeAfterRiskyTest'],
        'addSkippedTest' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterSkippedTestHook', 'executeAfterSkippedTest'],
        'addError' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterTestErrorHook', 'executeAfterTestError'],
        'addFailure' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterTestFailureHook', 'executeAfterTestFailure'],
        'addWarning' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterTestWarningHook', 'executeAfterTestWarning'],
        # test
        'startTest' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\BeforeTestHook', 'executeBeforeTest'],
        'endTest' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterTestHook', 'executeAfterTest'],
        # suite
        'startTestSuite' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\BeforeFirstTestHook', 'executeBeforeFirstTest'],
        'endTestSuite' => ['_PhpScopere8e811afab72\\PHPUnit\\Runner\\AfterLastTestHook', 'executeAfterLastTest'],
    ];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Refactor "*TestListener.php" to particular "*Hook.php" files', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace App\Tests;

use PHPUnit\Framework\TestListener;

final class BeforeListHook implements TestListener
{
    public function addError(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {
    }

    public function startTestSuite(TestSuite $suite): void
    {
    }

    public function endTestSuite(TestSuite $suite): void
    {
    }

    public function startTest(Test $test): void
    {
        echo 'start test!';
    }

    public function endTest(Test $test, float $time): void
    {
        echo $time;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace App\Tests;

final class BeforeListHook implements \PHPUnit\Runner\BeforeTestHook, \PHPUnit\Runner\AfterTestHook
{
    public function executeBeforeTest(Test $test): void
    {
        echo 'start test!';
    }

    public function executeAfterTest(Test $test, float $time): void
    {
        echo $time;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * List of nodes this class checks, classes that implement @see \PhpParser\Node
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * Process Node of matched type
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestListener')) {
            return null;
        }
        foreach ($node->implements as $implement) {
            if ($this->isName($implement, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestListener')) {
                $this->removeNode($implement);
            }
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        return $node;
    }
    private function processClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        foreach (self::LISTENER_METHOD_TO_HOOK_INTERFACES as $methodName => $hookClassAndMethod) {
            /** @var string $methodName */
            if (!$this->isName($classMethod, $methodName)) {
                continue;
            }
            // remove empty methods
            if ($classMethod->stmts === [] || $classMethod->stmts === null) {
                $this->removeNode($classMethod);
            } else {
                $class->implements[] = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($hookClassAndMethod[0]);
                $classMethod->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($hookClassAndMethod[1]);
            }
        }
    }
}
