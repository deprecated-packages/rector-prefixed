<?php

declare (strict_types=1);
namespace Rector\Symfony\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\GetToConstructorInjectionRectorTest
 */
final class GetToConstructorInjectionRector extends \Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const GET_METHOD_AWARE_TYPES = '$getMethodAwareTypes';
    /**
     * @var string[]
     */
    private $getMethodAwareTypes = ['Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller', 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerTrait'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fetching of dependencies via `$this->get()` to constructor injection in Command and Controller in Symfony', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class MyCommand extends ContainerAwareCommand
{
    public function someMethod()
    {
        // ...
        $this->get('some_service');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class MyCommand extends Command
{
    public function __construct(SomeService $someService)
    {
        $this->someService = $someService;
    }

    public function someMethod()
    {
        $this->someService;
    }
}
CODE_SAMPLE
, [self::GET_METHOD_AWARE_TYPES => ['SymfonyControllerClassName', 'GetTraitClassName']])]);
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
        if (!$this->isObjectTypes($node->var, $this->getMethodAwareTypes)) {
            return null;
        }
        if (!$this->isName($node->name, 'get')) {
            return null;
        }
        return $this->processMethodCallNode($node);
    }
    public function configure(array $configuration) : void
    {
        $this->getMethodAwareTypes = $configuration[self::GET_METHOD_AWARE_TYPES] ?? [];
    }
}
