<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\RemovingStatic\Printer\FactoryClassPrinter;
use _PhpScopere8e811afab72\Rector\RemovingStatic\StaticTypesInClassResolver;
use _PhpScopere8e811afab72\Rector\RemovingStatic\UniqueObjectFactoryFactory;
use _PhpScopere8e811afab72\Rector\RemovingStatic\UniqueObjectOrServiceDetector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\PassFactoryToEntityRectorTest
 */
final class PassFactoryToUniqueObjectRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const TYPES_TO_SERVICES = '$typesToServices';
    /**
     * @var string[]
     */
    private $typesToServices = [];
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
    public function __construct(\_PhpScopere8e811afab72\Rector\RemovingStatic\StaticTypesInClassResolver $staticTypesInClassResolver, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScopere8e811afab72\Rector\RemovingStatic\UniqueObjectOrServiceDetector $uniqueObjectOrServiceDetector, \_PhpScopere8e811afab72\Rector\RemovingStatic\UniqueObjectFactoryFactory $uniqueObjectFactoryFactory, \_PhpScopere8e811afab72\Rector\RemovingStatic\Printer\FactoryClassPrinter $factoryClassPrinter)
    {
        $this->propertyNaming = $propertyNaming;
        $this->uniqueObjectOrServiceDetector = $uniqueObjectOrServiceDetector;
        $this->uniqueObjectFactoryFactory = $uniqueObjectFactoryFactory;
        $this->factoryClassPrinter = $factoryClassPrinter;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert new X/Static::call() to factories in entities, pass them via constructor to each other', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScopere8e811afab72;

class SomeClass
{
    public function run()
    {
        return new \_PhpScopere8e811afab72\AnotherClass();
    }
}
\class_alias('_PhpScopere8e811afab72\\SomeClass', 'SomeClass', \false);
class AnotherClass
{
    public function someFun()
    {
        return \_PhpScopere8e811afab72\StaticClass::staticMethod();
    }
}
\class_alias('_PhpScopere8e811afab72\\AnotherClass', 'AnotherClass', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
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
, [self::TYPES_TO_SERVICES => ['StaticClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->refactorClass($node);
        }
        foreach ($this->typesToServices as $type) {
            if (!$this->isObjectType($node->class, $type)) {
                continue;
            }
            $objectType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($type);
            // is this object created via new somewhere else? use factory!
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $thisPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $variableName);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($thisPropertyFetch, $node->name, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->typesToServices = $configuration[self::TYPES_TO_SERVICES] ?? [];
    }
    private function refactorClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $staticTypesInClass = $this->staticTypesInClassResolver->collectStaticCallTypeInClass($class, $this->typesToServices);
        foreach ($staticTypesInClass as $staticType) {
            $variableName = $this->propertyNaming->fqnToVariableName($staticType);
            $this->addConstructorDependencyToClass($class, $staticType, $variableName);
            // is this an object? create factory for it next to this :)
            if ($this->uniqueObjectOrServiceDetector->isUniqueObject()) {
                $factoryClass = $this->uniqueObjectFactoryFactory->createFactoryClass($class, $staticType);
                $this->factoryClassPrinter->printFactoryForClass($factoryClass, $class);
            }
        }
        return $class;
    }
}
