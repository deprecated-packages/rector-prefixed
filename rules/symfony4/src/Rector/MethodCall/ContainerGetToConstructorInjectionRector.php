<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Ref: https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md#console
 * @see \Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\ContainerGetToConstructorInjectionRectorTest
 */
final class ContainerGetToConstructorInjectionRector extends \_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const CONTAINER_AWARE_PARENT_TYPES = '$containerAwareParentTypes';
    /**
     * @var string[]
     */
    private $containerAwareParentTypes = ['_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerAwareCommand', '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fetching of dependencies via `$container->get()` in ContainerAware to constructor injection in Command and Controller in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeCommand extends ContainerAwareCommand
{
    public function someMethod()
    {
        // ...
        $this->getContainer()->get('some_service');
        $this->container->get('some_service');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeCommand extends Command
{
    public function __construct(SomeService $someService)
    {
        $this->someService = $someService;
    }

    public function someMethod()
    {
        // ...
        $this->someService;
        $this->someService;
    }
}
CODE_SAMPLE
, [self::CONTAINER_AWARE_PARENT_TYPES => ['ContainerAwareParentClassName', 'ContainerAwareParentCommandClassName', 'ThisClassCallsMethodInConstructorClassName']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ContainerInterface')) {
            return null;
        }
        if (!$this->isName($node->name, 'get')) {
            return null;
        }
        $parentClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if (!\in_array($parentClassName, $this->containerAwareParentTypes, \true)) {
            return null;
        }
        return $this->processMethodCallNode($node);
    }
    public function configure(array $configuration) : void
    {
        $this->containerAwareParentTypes = $configuration[self::CONTAINER_AWARE_PARENT_TYPES] ?? [];
    }
}
