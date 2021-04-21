<?php

declare(strict_types=1);

namespace Rector\RemovingStatic\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Naming\PropertyNaming;
use Rector\RemovingStatic\Printer\FactoryClassPrinter;
use Rector\RemovingStatic\StaticTypesInClassResolver;
use Rector\RemovingStatic\UniqueObjectFactoryFactory;
use Rector\RemovingStatic\UniqueObjectOrServiceDetector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\RemovingStatic\Rector\Class_\PassFactoryToEntityRector\PassFactoryToEntityRectorTest
 */
final class PassFactoryToUniqueObjectRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    const TYPES_TO_SERVICES = 'types_to_services';

    /**
     * @var ObjectType[]
     */
    private $serviceObjectTypes = [];

    /**
     * @var PropertyNaming
     */
    private $propertyNaming;

    /**
     * @var UniqueObjectOrServiceDetector
     */
    private $uniqueObjectOrServiceDetector;

    /**
     * @var UniqueObjectFactoryFactory
     */
    private $uniqueObjectFactoryFactory;

    /**
     * @var FactoryClassPrinter
     */
    private $factoryClassPrinter;

    /**
     * @var StaticTypesInClassResolver
     */
    private $staticTypesInClassResolver;

    public function __construct(
        StaticTypesInClassResolver $staticTypesInClassResolver,
        PropertyNaming $propertyNaming,
        UniqueObjectOrServiceDetector $uniqueObjectOrServiceDetector,
        UniqueObjectFactoryFactory $uniqueObjectFactoryFactory,
        FactoryClassPrinter $factoryClassPrinter
    ) {
        $this->propertyNaming = $propertyNaming;
        $this->uniqueObjectOrServiceDetector = $uniqueObjectOrServiceDetector;
        $this->uniqueObjectFactoryFactory = $uniqueObjectFactoryFactory;
        $this->factoryClassPrinter = $factoryClassPrinter;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Convert new X/Static::call() to factories in entities, pass them via constructor to each other', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
<?php

class SomeClass
{
    public function run()
    {
        return new AnotherClass;
    }
}

class AnotherClass
{
    public function someFun()
    {
        return StaticClass::staticMethod();
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(AnotherClassFactory $anotherClassFactory)
    {
        $this->anotherClassFactory = $anotherClassFactory;
    }

    public function run()
    {
        return $this->anotherClassFactory->create();
    }
}

class AnotherClass
{
    public function __construct(StaticClass $staticClass)
    {
        $this->staticClass = $staticClass;
    }

    public function someFun()
    {
        return $this->staticClass->staticMethod();
    }
}

final class AnotherClassFactory
{
    /**
     * @var StaticClass
     */
    private $staticClass;

    public function __construct(StaticClass $staticClass)
    {
        $this->staticClass = $staticClass;
    }

    public function create(): AnotherClass
    {
        return new AnotherClass($this->staticClass);
    }
}
CODE_SAMPLE
                ,
                [
                    self::TYPES_TO_SERVICES => ['StaticClass'],
                ]
            ), ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class, StaticCall::class];
    }

    /**
     * @param StaticCall|Class_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof Class_) {
            return $this->refactorClass($node);
        }

        foreach ($this->serviceObjectTypes as $serviceObjectType) {
            if (! $this->isObjectType($node->class, $serviceObjectType)) {
                continue;
            }

            // is this object created via new somewhere else? use factory!
            $variableName = $this->propertyNaming->fqnToVariableName($serviceObjectType);
            $thisPropertyFetch = new PropertyFetch(new Variable('this'), $variableName);

            return new MethodCall($thisPropertyFetch, $node->name, $node->args);
        }

        return $node;
    }

    /**
     * @param array<string, mixed[]> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $typesToServices = $configuration[self::TYPES_TO_SERVICES] ?? [];
        foreach ($typesToServices as $typeToService) {
            $this->serviceObjectTypes[] = new ObjectType($typeToService);
        }
    }

    private function refactorClass(Class_ $class): Class_
    {
        $staticTypesInClass = $this->staticTypesInClassResolver->collectStaticCallTypeInClass(
            $class,
            $this->serviceObjectTypes
        );

        foreach ($staticTypesInClass as $staticTypeInClass) {
            $variableName = $this->propertyNaming->fqnToVariableName($staticTypeInClass);
            $this->addConstructorDependencyToClass($class, $staticTypeInClass, $variableName);

            // is this an object? create factory for it next to this :)
            if ($this->uniqueObjectOrServiceDetector->isUniqueObject()) {
                $factoryClass = $this->uniqueObjectFactoryFactory->createFactoryClass($class, $staticTypeInClass);

                $this->factoryClassPrinter->printFactoryForClass($factoryClass, $class);
            }
        }

        return $class;
    }
}
