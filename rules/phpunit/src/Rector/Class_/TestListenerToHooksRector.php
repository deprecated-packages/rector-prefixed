<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/3388
 * @see https://github.com/sebastianbergmann/phpunit/commit/34a0abd8b56a4a9de83c9e56384f462541a0f939
 *
 * @see https://github.com/sebastianbergmann/phpunit/tree/master/src/Runner/Hook
 * @see \Rector\PHPUnit\Tests\Rector\Class_\TestListenerToHooksRector\TestListenerToHooksRectorTest
 */
final class TestListenerToHooksRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[][]
     */
    private const LISTENER_METHOD_TO_HOOK_INTERFACES = [
        'addIncompleteTest' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterIncompleteTestHook', 'executeAfterIncompleteTest'],
        'addRiskyTest' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterRiskyTestHook', 'executeAfterRiskyTest'],
        'addSkippedTest' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterSkippedTestHook', 'executeAfterSkippedTest'],
        'addError' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterTestErrorHook', 'executeAfterTestError'],
        'addFailure' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterTestFailureHook', 'executeAfterTestFailure'],
        'addWarning' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterTestWarningHook', 'executeAfterTestWarning'],
        # test
        'startTest' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\BeforeTestHook', 'executeBeforeTest'],
        'endTest' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterTestHook', 'executeAfterTest'],
        # suite
        'startTestSuite' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\BeforeFirstTestHook', 'executeBeforeFirstTest'],
        'endTestSuite' => ['RectorPrefix2020DecSat\\PHPUnit\\Runner\\AfterLastTestHook', 'executeAfterLastTest'],
    ];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Refactor "*TestListener.php" to particular "*Hook.php" files', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * Process Node of matched type
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, 'RectorPrefix2020DecSat\\PHPUnit\\Framework\\TestListener')) {
            return null;
        }
        foreach ($node->implements as $implement) {
            if ($this->isName($implement, 'RectorPrefix2020DecSat\\PHPUnit\\Framework\\TestListener')) {
                $this->removeNode($implement);
            }
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        return $node;
    }
    private function processClassMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
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
                $class->implements[] = new \PhpParser\Node\Name\FullyQualified($hookClassAndMethod[0]);
                $classMethod->name = new \PhpParser\Node\Identifier($hookClassAndMethod[1]);
            }
        }
    }
}
