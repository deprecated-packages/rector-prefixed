<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Laravel\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/issues/26450#issuecomment-449401202
 * @see https://github.com/laravel/framework/commit/055fe52dbb7169dc51bd5d5deeb05e8da9be0470#diff-76a649cb397ea47f5613459c335f88c1b68e5f93e51d46e9fb5308ec55ded221
 *
 * @see \Rector\Laravel\Tests\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector\AddMockConsoleOutputFalseToConsoleTestsRectorTest
 */
final class AddMockConsoleOutputFalseToConsoleTestsRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var SetUpClassMethodNodeManipulator
     */
    private $setUpClassMethodNodeManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \_PhpScoper0a2ac50786fa\Rector\PHPUnit\NodeManipulator\SetUpClassMethodNodeManipulator $setUpClassMethodNodeManipulator)
    {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->setUpClassMethodNodeManipulator = $setUpClassMethodNodeManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add "$this->mockConsoleOutput = false"; to console tests that work with output content', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper0a2ac50786fa\\Illuminate\\Foundation\\Testing\\TestCase')) {
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
    private function isTestingConsoleOutput(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $class->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $this->isStaticCallNamed($node, '_PhpScoper0a2ac50786fa\\Illuminate\\Support\\Facades\\Artisan', 'output');
        });
    }
    private function hasMockConsoleOutputFalse(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($class, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                if (!$this->propertyFetchAnalyzer->isLocalPropertyFetchName($node->var, 'mockConsoleOutput')) {
                    return \false;
                }
                return $this->isFalse($node->expr);
            }
            return \false;
        });
    }
    private function createAssign() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        $propertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), 'mockConsoleOutput');
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($propertyFetch, $this->createFalse());
    }
}
