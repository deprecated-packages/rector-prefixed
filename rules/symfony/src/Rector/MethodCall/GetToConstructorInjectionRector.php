<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\MethodCall\GetToConstructorInjectionRector\GetToConstructorInjectionRectorTest
 */
final class GetToConstructorInjectionRector extends \_PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const GET_METHOD_AWARE_TYPES = '$getMethodAwareTypes';
    /**
     * @var string[]
     */
    private $getMethodAwareTypes = ['_PhpScoper0a6b37af0871\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller', '_PhpScoper0a6b37af0871\\Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerTrait'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fetching of dependencies via `$this->get()` to constructor injection in Command and Controller in Symfony', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
