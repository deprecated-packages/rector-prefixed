<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\ServiceGetterToConstructorInjectionRectorTest
 */
final class ServiceGetterToConstructorInjectionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_TO_SERVICES = 'method_call_to_services';
    /**
     * @var ServiceGetterToConstructorInjection[]
     */
    private $methodCallToServices = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Get service call to constructor injection', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var FirstService
     */
    private $firstService;

    public function __construct(FirstService $firstService)
    {
        $this->firstService = $firstService;
    }

    public function run()
    {
        $anotherService = $this->firstService->getAnotherService();
        $anotherService->run();
    }
}

class FirstService
{
    /**
     * @var AnotherService
     */
    private $anotherService;

    public function __construct(AnotherService $anotherService)
    {
        $this->anotherService = $anotherService;
    }

    public function getAnotherService(): AnotherService
    {
         return $this->anotherService;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var FirstService
     */
    private $firstService;

    /**
     * @var AnotherService
     */
    private $anotherService;

    public function __construct(FirstService $firstService, AnotherService $anotherService)
    {
        $this->firstService = $firstService;
        $this->anotherService = $anotherService;
    }

    public function run()
    {
        $anotherService = $this->anotherService;
        $anotherService->run();
    }
}
CODE_SAMPLE
, [self::METHOD_CALL_TO_SERVICES => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection('FirstService', 'getAnotherService', 'AnotherService')]])]);
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
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$this->isNonAnonymousClass($classLike)) {
            return null;
        }
        foreach ($this->methodCallToServices as $methodCallToService) {
            if (!$this->isObjectType($node->var, $methodCallToService->getOldType())) {
                continue;
            }
            if (!$this->isName($node->name, $methodCallToService->getOldMethod())) {
                continue;
            }
            $serviceObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($methodCallToService->getServiceType());
            $propertyName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
            /** @var Class_ $classLike */
            $this->addConstructorDependencyToClass($classLike, $serviceObjectType, $propertyName);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($propertyName));
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $methodCallToServices = $configuration[self::METHOD_CALL_TO_SERVICES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($methodCallToServices, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ServiceGetterToConstructorInjection::class);
        $this->methodCallToServices = $methodCallToServices;
    }
}
