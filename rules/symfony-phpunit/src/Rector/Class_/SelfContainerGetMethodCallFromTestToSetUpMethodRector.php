<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory;
use _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SymfonyPHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector\SelfContainerGetMethodCallFromTestToSetUpMethodRectorTest
 */
final class SelfContainerGetMethodCallFromTestToSetUpMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var KernelTestCaseNodeFactory
     */
    private $kernelTestCaseNodeFactory;
    /**
     * @var SelfContainerMethodCallCollector
     */
    private $selfContainerMethodCallCollector;
    /**
     * @var OnContainerGetCallManipulator
     */
    private $onContainerGetCallManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory $kernelTestCaseNodeFactory, \_PhpScopere8e811afab72\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator $onContainerGetCallManipulator, \_PhpScopere8e811afab72\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector $selfContainerMethodCallCollector)
    {
        $this->kernelTestCaseNodeFactory = $kernelTestCaseNodeFactory;
        $this->selfContainerMethodCallCollector = $selfContainerMethodCallCollector;
        $this->onContainerGetCallManipulator = $onContainerGetCallManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move self::$container service fetching from test methods up to setUp method', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use ItemRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SomeTest extends KernelTestCase
{
    public function testOne()
    {
        $itemRepository = $this->getService(ItemRepository::class);
        $itemRepository->doStuff();
    }

    public function testTwo()
    {
        $itemRepository = $this->getService(ItemRepository::class);
        $itemRepository->doAnotherStuff();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use ItemRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SomeTest extends KernelTestCase
{
    /**
     * @var \ItemRepository
     */
    private $itemRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->itemRepository = $this->getService(ItemRepository::class);
    }

    public function testOne()
    {
        $this->itemRepository->doStuff();
    }

    public function testTwo()
    {
        $this->itemRepository->doAnotherStuff();
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
        // 1. find $this->getService(<X>)
        $serviceTypes = $this->selfContainerMethodCallCollector->collectContainerGetServiceTypes($node);
        if ($serviceTypes === []) {
            return null;
        }
        // 2. put them to setUp() method
        $setUpClassMethod = $node->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP);
        if ($setUpClassMethod === null) {
            $setUpClassMethod = $this->kernelTestCaseNodeFactory->createSetUpClassMethodWithGetTypes($node, $serviceTypes);
            if ($setUpClassMethod !== null) {
                $node->stmts = \array_merge([$setUpClassMethod], $node->stmts);
            }
        } else {
            $assigns = $this->kernelTestCaseNodeFactory->createSelfContainerGetWithTypeAssigns($node, $serviceTypes);
            $setUpClassMethod->stmts = \array_merge((array) $setUpClassMethod->stmts, $assigns);
        }
        // 3. create private properties with this types
        $privateProperties = $this->kernelTestCaseNodeFactory->createPrivatePropertiesFromTypes($node, $serviceTypes);
        $node->stmts = \array_merge($privateProperties, $node->stmts);
        // 4. remove old in-method $property assigns
        $this->onContainerGetCallManipulator->removeAndCollectFormerAssignedVariables($node);
        // 5. replace former variables by $this->someProperty
        $this->onContainerGetCallManipulator->replaceFormerVariablesWithPropertyFetch($node);
        return $node;
    }
}
