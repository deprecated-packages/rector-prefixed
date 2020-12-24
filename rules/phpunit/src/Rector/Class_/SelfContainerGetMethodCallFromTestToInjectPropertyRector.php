<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Inspiration
 * @see SelfContainerGetMethodCallFromTestToSetUpMethodRector
 *
 * @see https://github.com/shopsys/shopsys/pull/1392
 * @see https://github.com/jakzal/phpunit-injector
 *
 * @see \Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\SelfContainerGetMethodCallFromTestToInjectPropertyRectorTest
 */
final class SelfContainerGetMethodCallFromTestToInjectPropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var SelfContainerMethodCallCollector
     */
    private $selfContainerMethodCallCollector;
    /**
     * @var KernelTestCaseNodeFactory
     */
    private $kernelTestCaseNodeFactory;
    /**
     * @var OnContainerGetCallManipulator
     */
    private $onContainerGetCallManipulator;
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var FormerVariablesByMethodCollector
     */
    private $formerVariablesByMethodCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory $kernelTestCaseNodeFactory, \_PhpScopere8e811afab72\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator $onContainerGetCallManipulator, \_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector $selfContainerMethodCallCollector, \_PhpScopere8e811afab72\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
    {
        $this->selfContainerMethodCallCollector = $selfContainerMethodCallCollector;
        $this->kernelTestCaseNodeFactory = $kernelTestCaseNodeFactory;
        $this->onContainerGetCallManipulator = $onContainerGetCallManipulator;
        $this->classManipulator = $classManipulator;
        $this->formerVariablesByMethodCollector = $formerVariablesByMethodCollector;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $container->get() calls in PHPUnit to @inject properties autowired by jakzal/phpunit-injector', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;
class SomeClassTest extends TestCase {
    public function test()
    {
        $someService = $this->getContainer()->get(SomeService::class);
    }
}

class SomeService
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;
class SomeClassTest extends TestCase {
    /**
     * @var SomeService
     * @inject
     */
    private $someService;
    public function test()
    {
        $someService = $this->someService;
    }
}

class SomeService
{
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
        if (!$this->isInTestClass($node)) {
            return null;
        }
        // 1. find $this->getService(x)
        $serviceTypes = $this->selfContainerMethodCallCollector->collectContainerGetServiceTypes($node, \false);
        if ($serviceTypes === []) {
            return null;
        }
        // 2. - add @inject to existing properties of that type, to prevent re-adding them
        foreach ($serviceTypes as $key => $serviceType) {
            $existingProperty = $this->classManipulator->findPropertyByType($node, $serviceType);
            if ($existingProperty !== null) {
                $this->addInjectAnnotationToProperty($existingProperty);
                unset($serviceTypes[$key]);
            }
        }
        // 3. create private properties with this types
        $privateProperties = $this->kernelTestCaseNodeFactory->createPrivatePropertiesFromTypes($node, $serviceTypes);
        $this->addInjectAnnotationToProperties($privateProperties);
        $node->stmts = \array_merge($privateProperties, $node->stmts);
        // 4. remove old in-method $property assigns
        $this->formerVariablesByMethodCollector->reset();
        $this->onContainerGetCallManipulator->removeAndCollectFormerAssignedVariables($node, \false);
        // 4. replace former variables by $this->someProperty
        $this->onContainerGetCallManipulator->replaceFormerVariablesWithPropertyFetch($node);
        return $node;
    }
    private function addInjectAnnotationToProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $privateProperty) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $privateProperty->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addBareTag('@inject');
    }
    /**
     * @param Property[] $properties
     */
    private function addInjectAnnotationToProperties(array $properties) : void
    {
        foreach ($properties as $property) {
            $this->addInjectAnnotationToProperty($property);
        }
    }
}
