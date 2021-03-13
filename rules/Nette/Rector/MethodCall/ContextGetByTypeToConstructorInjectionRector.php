<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\Symfony\NodeAnalyzer\DependencyInjectionMethodCallAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\ContextGetByTypeToConstructorInjectionRectorTest
 */
final class ContextGetByTypeToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    /**
     * @var DependencyInjectionMethodCallAnalyzer
     */
    private $dependencyInjectionMethodCallAnalyzer;
    public function __construct(\Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer, \Rector\Symfony\NodeAnalyzer\DependencyInjectionMethodCallAnalyzer $dependencyInjectionMethodCallAnalyzer)
    {
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
        $this->dependencyInjectionMethodCallAnalyzer = $dependencyInjectionMethodCallAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move dependency get via $context->getByType() to constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Nette\DI\Container
     */
    private $context;

    public function run()
    {
        $someTypeToInject = $this->context->getByType(SomeTypeToInject::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Nette\DI\Container
     */
    private $context;

    public function __construct(private SomeTypeToInject $someTypeToInject)
    {
    }

    public function run()
    {
        $someTypeToInject = $this->someTypeToInject;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->testsNodeAnalyzer->isInTestClass($node)) {
            return null;
        }
        if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if (!$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('Nette\\DI\\Container'))) {
            return null;
        }
        if (!$this->isName($node->name, 'getByType')) {
            return null;
        }
        return $this->dependencyInjectionMethodCallAnalyzer->replaceMethodCallWithPropertyFetchAndDependency($node);
    }
}
