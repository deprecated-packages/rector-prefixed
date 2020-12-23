<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\MockistaToMockery\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\MockistaToMockery\MockistaDetector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockistaToMockery\Tests\Rector\Class_\MockeryTearDownRector\MockeryTearDownRectorTest
 */
final class MockeryTearDownRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MockistaDetector
     */
    private $mockistaDetector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\MockistaToMockery\MockistaDetector $mockistaDetector)
    {
        $this->mockistaDetector = $mockistaDetector;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add Mockery::close() in tearDown() method if not yet', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->mockistaDetector->isInClass($node)) {
            return null;
        }
        $tearDownClassMethod = $node->getMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        if ($tearDownClassMethod === null) {
            $node->stmts[] = $this->createTearDownMethodWithMockeryClose();
        } elseif (!$this->containsMockeryClose($tearDownClassMethod)) {
            $tearDownClassMethod->stmts[] = $this->createMockeryClose();
        }
        return $node;
    }
    private function createTearDownMethodWithMockeryClose() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
        $methodBuilder->setReturnType('void');
        $methodBuilder->makeProtected();
        $staticCall = $this->createMockeryClose();
        $methodBuilder->addStmt($staticCall);
        return $methodBuilder->getNode();
    }
    private function containsMockeryClose(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            if (!$this->isName($node->class, 'Mockery')) {
                return \false;
            }
            return $this->isName($node->name, 'close');
        });
    }
    private function createMockeryClose() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
    {
        $staticCall = $this->createStaticCall('Mockery', 'close');
        return \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeStmt($staticCall);
    }
}
