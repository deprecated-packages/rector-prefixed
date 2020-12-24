<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/3975#issuecomment-562584609
 *
 * @see \Rector\PHPUnit\Tests\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector\ConstructClassMethodToSetUpTestCaseRectorTest
 */
final class ConstructClassMethodToSetUpTestCaseRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var SetUpClassMethodNodeManipulator
     */
    private $setUpClassMethodNodeManipulator;
    /**
     * @var StaticCallAnalyzer
     */
    private $staticCallAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator $setUpClassMethodNodeManipulator, \_PhpScoper0a6b37af0871\Rector\Nette\NodeAnalyzer\StaticCallAnalyzer $staticCallAnalyzer)
    {
        $this->setUpClassMethodNodeManipulator = $setUpClassMethodNodeManipulator;
        $this->staticCallAnalyzer = $staticCallAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change __construct() method in tests of `PHPUnit\\Framework\\TestCase` to setUp(), to prevent dangerous override', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    private $someValue;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->someValue = 1000;
        parent::__construct($name, $data, $dataName);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    private $someValue;

    protected function setUp()
    {
        parent::setUp();

        $this->someValue = 1000;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $constructClassMethod = $node->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return null;
        }
        $this->removeNode($constructClassMethod);
        $addedStmts = $this->resolveStmtsToAddToSetUp($constructClassMethod);
        $this->setUpClassMethodNodeManipulator->decorateOrCreate($node, $addedStmts);
        return $node;
    }
    /**
     * @return Stmt[]
     */
    private function resolveStmtsToAddToSetUp(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $constructClassMethod) : array
    {
        $constructorStmts = (array) $constructClassMethod->stmts;
        // remove parent call
        foreach ($constructorStmts as $key => $constructorStmt) {
            if ($constructorStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                $constructorStmt = clone $constructorStmt->expr;
            }
            if (!$this->staticCallAnalyzer->isParentCallNamed($constructorStmt, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                continue;
            }
            unset($constructorStmts[$key]);
        }
        return $constructorStmts;
    }
}
