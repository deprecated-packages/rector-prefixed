<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator;
use _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory;
use _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector;
use _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Inspiration
 * @see SelfContainerGetMethodCallFromTestToSetUpMethodRector
 *
 * @see https://github.com/shopsys/shopsys/pull/1392
 * @see https://github.com/jakzal/phpunit-injector
 *
 * @see \Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\SelfContainerGetMethodCallFromTestToInjectPropertyRectorTest
 */
final class SelfContainerGetMethodCallFromTestToInjectPropertyRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Node\KernelTestCaseNodeFactory $kernelTestCaseNodeFactory, \_PhpScoper0a2ac50786fa\Rector\PHPUnit\Manipulator\OnContainerGetCallManipulator $onContainerGetCallManipulator, \_PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\SelfContainerMethodCallCollector $selfContainerMethodCallCollector, \_PhpScoper0a2ac50786fa\Rector\PHPUnit\Collector\FormerVariablesByMethodCollector $formerVariablesByMethodCollector)
    {
        $this->selfContainerMethodCallCollector = $selfContainerMethodCallCollector;
        $this->kernelTestCaseNodeFactory = $kernelTestCaseNodeFactory;
        $this->onContainerGetCallManipulator = $onContainerGetCallManipulator;
        $this->classManipulator = $classManipulator;
        $this->formerVariablesByMethodCollector = $formerVariablesByMethodCollector;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $container->get() calls in PHPUnit to @inject properties autowired by jakzal/phpunit-injector', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        // 1. find self::$container->get(x)
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
    private function addInjectAnnotationToProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $privateProperty) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $privateProperty->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
