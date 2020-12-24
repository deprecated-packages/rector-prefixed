<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/issues/26450#issuecomment-449401202
 * @see https://github.com/laravel/framework/commit/055fe52dbb7169dc51bd5d5deeb05e8da9be0470#diff-76a649cb397ea47f5613459c335f88c1b68e5f93e51d46e9fb5308ec55ded221
 *
 * @see \Rector\Laravel\Tests\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector\AddMockConsoleOutputFalseToConsoleTestsRectorTest
 */
final class AddMockConsoleOutputFalseToConsoleTestsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var SetUpClassMethodNodeManipulator
     */
    private $setUpClassMethodNodeManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \_PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator $setUpClassMethodNodeManipulator)
    {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->setUpClassMethodNodeManipulator = $setUpClassMethodNodeManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add "$this->mockConsoleOutput = false"; to console tests that work with output content', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase;

final class SomeTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals('content', \trim((new Artisan())::output()));
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase;

final class SomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->mockConsoleOutput = false;
    }

    public function test(): void
    {
        $this->assertEquals('content', \trim((new Artisan())::output()));
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
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\Illuminate\\Foundation\\Testing\\TestCase')) {
            return null;
        }
        if (!$this->isTestingConsoleOutput($node)) {
            return null;
        }
        // has setUp with property `$mockConsoleOutput = false`
        if ($this->hasMockConsoleOutputFalse($node)) {
            return null;
        }
        $assign = $this->createAssign();
        $this->setUpClassMethodNodeManipulator->decorateOrCreate($node, [$assign]);
        return $node;
    }
    private function isTestingConsoleOutput(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $class->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return $this->isStaticCallNamed($node, '_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Artisan', 'output');
        });
    }
    private function hasMockConsoleOutputFalse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($class, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                if (!$this->propertyFetchAnalyzer->isLocalPropertyFetchName($node->var, 'mockConsoleOutput')) {
                    return \false;
                }
                return $this->isFalse($node->expr);
            }
            return \false;
        });
    }
    private function createAssign() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), 'mockConsoleOutput');
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $this->createFalse());
    }
}
