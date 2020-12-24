<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MockeryToProphecy\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockeryToProphecy\Tests\Rector\ClassMethod\MockeryToProphecyRector\MockeryToProphecyRectorTest
 */
final class MockeryCreateMockToProphizeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, class-string>
     */
    private $mockVariableTypesByNames = [];
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $this->replaceMockCreationsAndCollectVariableNames($node);
        $this->revealMockArguments($node);
        return $node;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes mockery mock creation to Prophesize', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$mock = \Mockery::mock(\'MyClass\');
$service = new Service();
$service->injectDependency($mock);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
 $mock = $this->prophesize(\'MyClass\');

$service = new Service();
$service->injectDependency($mock->reveal());
CODE_SAMPLE
)]);
    }
    private function replaceMockCreationsAndCollectVariableNames(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->stmts === null) {
            return;
        }
        $this->traverseNodesWithCallable($classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?MethodCall {
            if (!$this->isStaticCallNamed($node, 'Mockery', 'mock')) {
                return null;
            }
            /** @var StaticCall $node */
            $this->collectMockVariableName($node);
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
                $prophesizeMethodCall = $this->createProphesizeMethodCall($node);
                return $this->createMethodCall($prophesizeMethodCall, 'reveal');
            }
            return $this->createProphesizeMethodCall($node);
        });
    }
    private function revealMockArguments(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->stmts === null) {
            return;
        }
        $this->traverseNodesWithCallable($classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?MethodCall {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
                return null;
            }
            if (!$node->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            /** @var string $variableName */
            $variableName = $this->getName($node->value);
            if (!isset($this->mockVariableTypesByNames[$variableName])) {
                return null;
            }
            return $this->createMethodCall($node->value, 'reveal');
        });
    }
    private function collectMockVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $parentNode = $staticCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return;
        }
        if (!$parentNode->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return;
        }
        /** @var Variable $variable */
        $variable = $parentNode->var;
        /** @var string $variableName */
        $variableName = $this->getName($variable);
        $type = $staticCall->args[0]->value;
        $mockedType = $this->getValue($type);
        $this->mockVariableTypesByNames[$variableName] = $mockedType;
    }
    private function createProphesizeMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        return $this->createLocalMethodCall('prophesize', [$staticCall->args[0]]);
    }
}
