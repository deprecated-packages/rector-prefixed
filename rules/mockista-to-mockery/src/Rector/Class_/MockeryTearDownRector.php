<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\BuilderHelpers;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\MockistaToMockery\MockistaDetector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockistaToMockery\Tests\Rector\Class_\MockeryTearDownRector\MockeryTearDownRectorTest
 */
final class MockeryTearDownRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MockistaDetector
     */
    private $mockistaDetector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\MockistaToMockery\MockistaDetector $mockistaDetector)
    {
        $this->mockistaDetector = $mockistaDetector;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add Mockery::close() in tearDown() method if not yet', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->mockistaDetector->isInClass($node)) {
            return null;
        }
        $tearDownClassMethod = $node->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        if ($tearDownClassMethod === null) {
            $node->stmts[] = $this->createTearDownMethodWithMockeryClose();
        } elseif (!$this->containsMockeryClose($tearDownClassMethod)) {
            $tearDownClassMethod->stmts[] = $this->createMockeryClose();
        }
        return $node;
    }
    private function createTearDownMethodWithMockeryClose() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        $methodBuilder->setReturnType('void');
        $methodBuilder->makeProtected();
        $staticCall = $this->createMockeryClose();
        $methodBuilder->addStmt($staticCall);
        return $methodBuilder->getNode();
    }
    private function containsMockeryClose(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            if (!$this->isName($node->class, 'Mockery')) {
                return \false;
            }
            return $this->isName($node->name, 'close');
        });
    }
    private function createMockeryClose() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
    {
        $staticCall = $this->createStaticCall('Mockery', 'close');
        return \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeStmt($staticCall);
    }
}
