<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MockistaToMockery\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\BuilderHelpers;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\MockistaToMockery\MockistaDetector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockistaToMockery\Tests\Rector\Class_\MockeryTearDownRector\MockeryTearDownRectorTest
 */
final class MockeryTearDownRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MockistaDetector
     */
    private $mockistaDetector;
    public function __construct(\_PhpScopere8e811afab72\Rector\MockistaToMockery\MockistaDetector $mockistaDetector)
    {
        $this->mockistaDetector = $mockistaDetector;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add Mockery::close() in tearDown() method if not yet', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    public function test()
    {
        $mockUser = mock(User::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }
    public function test()
    {
        $mockUser = mock(User::class);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->mockistaDetector->isInClass($node)) {
            return null;
        }
        $tearDownClassMethod = $node->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        if ($tearDownClassMethod === null) {
            $node->stmts[] = $this->createTearDownMethodWithMockeryClose();
        } elseif (!$this->containsMockeryClose($tearDownClassMethod)) {
            $tearDownClassMethod->stmts[] = $this->createMockeryClose();
        }
        return $node;
    }
    private function createTearDownMethodWithMockeryClose() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        $methodBuilder->setReturnType('void');
        $methodBuilder->makeProtected();
        $staticCall = $this->createMockeryClose();
        $methodBuilder->addStmt($staticCall);
        return $methodBuilder->getNode();
    }
    private function containsMockeryClose(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            if (!$this->isName($node->class, 'Mockery')) {
                return \false;
            }
            return $this->isName($node->name, 'close');
        });
    }
    private function createMockeryClose() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt
    {
        $staticCall = $this->createStaticCall('Mockery', 'close');
        return \_PhpScopere8e811afab72\PhpParser\BuilderHelpers::normalizeStmt($staticCall);
    }
}
