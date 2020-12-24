<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MockeryToProphecy\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockeryToProphecy\Tests\Rector\ClassMethod\MockeryToProphecyRector\MockeryToProphecyRectorTest
 */
final class MockeryCreateMockToProphizeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $this->replaceMockCreationsAndCollectVariableNames($node);
        $this->revealMockArguments($node);
        return $node;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes mockery mock creation to Prophesize', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    private function replaceMockCreationsAndCollectVariableNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->stmts === null) {
            return;
        }
        $this->traverseNodesWithCallable($classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?MethodCall {
            if (!$this->isStaticCallNamed($node, 'Mockery', 'mock')) {
                return null;
            }
            /** @var StaticCall $node */
            $this->collectMockVariableName($node);
            $parentNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
                $prophesizeMethodCall = $this->createProphesizeMethodCall($node);
                return $this->createMethodCall($prophesizeMethodCall, 'reveal');
            }
            return $this->createProphesizeMethodCall($node);
        });
    }
    private function revealMockArguments(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->stmts === null) {
            return;
        }
        $this->traverseNodesWithCallable($classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?MethodCall {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
                return null;
            }
            if (!$node->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
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
    private function collectMockVariableName(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $parentNode = $staticCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return;
        }
        if (!$parentNode->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
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
    private function createProphesizeMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        return $this->createLocalMethodCall('prophesize', [$staticCall->args[0]]);
    }
}
