<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/3388
 * @see https://github.com/sebastianbergmann/phpunit/commit/34a0abd8b56a4a9de83c9e56384f462541a0f939
 *
 * @see https://github.com/sebastianbergmann/phpunit/tree/master/src/Runner/Hook
 * @see \Rector\PHPUnit\Tests\Rector\Class_\TestListenerToHooksRector\TestListenerToHooksRectorTest
 */
final class TestListenerToHooksRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[][]
     */
    private const LISTENER_METHOD_TO_HOOK_INTERFACES = [
        'addIncompleteTest' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterIncompleteTestHook', 'executeAfterIncompleteTest'],
        'addRiskyTest' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterRiskyTestHook', 'executeAfterRiskyTest'],
        'addSkippedTest' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterSkippedTestHook', 'executeAfterSkippedTest'],
        'addError' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterTestErrorHook', 'executeAfterTestError'],
        'addFailure' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterTestFailureHook', 'executeAfterTestFailure'],
        'addWarning' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterTestWarningHook', 'executeAfterTestWarning'],
        # test
        'startTest' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\BeforeTestHook', 'executeBeforeTest'],
        'endTest' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterTestHook', 'executeAfterTest'],
        # suite
        'startTestSuite' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\BeforeFirstTestHook', 'executeBeforeFirstTest'],
        'endTestSuite' => ['_PhpScoperb75b35f52b74\\PHPUnit\\Runner\\AfterLastTestHook', 'executeAfterLastTest'],
    ];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Refactor "*TestListener.php" to particular "*Hook.php" files', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * Process Node of matched type
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestListener')) {
            return null;
        }
        foreach ($node->implements as $implement) {
            if ($this->isName($implement, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestListener')) {
                $this->removeNode($implement);
            }
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        return $node;
    }
    private function processClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
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
                $class->implements[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($hookClassAndMethod[0]);
                $classMethod->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($hookClassAndMethod[1]);
            }
        }
    }
}
