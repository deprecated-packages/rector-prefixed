<?php

declare(strict_types=1);

namespace Rector\MockeryToProphecy\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\MockeryToProphecy\Collector\MockVariableCollector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\MockeryToProphecy\Rector\ClassMethod\MockeryToProphecyRector\MockeryToProphecyRectorTest
 */
final class MockeryCreateMockToProphizeRector extends AbstractRector
{
    /**
     * @var array<string, class-string>
     */
    private $mockVariableTypesByNames = [];

    /**
     * @var MockVariableCollector
     */
    private $mockVariableCollector;

    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;

    public function __construct(MockVariableCollector $mockVariableCollector, TestsNodeAnalyzer $testsNodeAnalyzer)
    {
        $this->mockVariableCollector = $mockVariableCollector;
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if (! $this->testsNodeAnalyzer->isInTestClass($node)) {
            return null;
        }

        $this->replaceMockCreationsAndCollectVariableNames($node);
        $this->revealMockArguments($node);

        return $node;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Changes mockery mock creation to Prophesize',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$mock = \Mockery::mock('MyClass');
$service = new Service();
$service->injectDependency($mock);
CODE_SAMPLE
,
                    <<<'CODE_SAMPLE'
 $mock = $this->prophesize('MyClass');

$service = new Service();
$service->injectDependency($mock->reveal());
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return void
     */
    private function replaceMockCreationsAndCollectVariableNames(ClassMethod $classMethod)
    {
        if ($classMethod->stmts === null) {
            return;
        }

        $this->traverseNodesWithCallable($classMethod->stmts, function (Node $node): ?MethodCall {
            if (! $node instanceof StaticCall) {
                return null;
            }

            $callerType = $this->nodeTypeResolver->resolve($node->class);
            if (! $callerType->isSuperTypeOf(new ObjectType('Mockery'))->yes()) {
                return null;
            }

            if (! $this->isName($node->name, 'mock')) {
                return null;
            }

            $collectedVariableTypesByNames = $this->mockVariableCollector->collectMockVariableName($node);

            $this->mockVariableTypesByNames = array_merge(
                $this->mockVariableTypesByNames,
                $collectedVariableTypesByNames
            );

            $parentNode = $node->getAttribute(AttributeKey::PARENT_NODE);
            if ($parentNode instanceof Arg) {
                $prophesizeMethodCall = $this->createProphesizeMethodCall($node);
                return $this->nodeFactory->createMethodCall($prophesizeMethodCall, 'reveal');
            }

            return $this->createProphesizeMethodCall($node);
        });
    }

    /**
     * @return void
     */
    private function revealMockArguments(ClassMethod $classMethod)
    {
        if ($classMethod->stmts === null) {
            return;
        }

        $this->traverseNodesWithCallable($classMethod->stmts, function (Node $node): ?MethodCall {
            if (! $node instanceof Arg) {
                return null;
            }

            if (! $node->value instanceof Variable) {
                return null;
            }

            /** @var string $variableName */
            $variableName = $this->getName($node->value);

            if (! isset($this->mockVariableTypesByNames[$variableName])) {
                return null;
            }

            return $this->nodeFactory->createMethodCall($node->value, 'reveal');
        });
    }

    private function createProphesizeMethodCall(StaticCall $staticCall): MethodCall
    {
        return $this->nodeFactory->createLocalMethodCall('prophesize', [$staticCall->args[0]]);
    }
}
