<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Printer\FactoryClassPrinter;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\StaticTypesInClassResolver;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\UniqueObjectFactoryFactory;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\UniqueObjectOrServiceDetector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\PassFactoryToEntityRectorTest
 */
final class PassFactoryToUniqueObjectRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\RemovingStatic\StaticTypesInClassResolver $staticTypesInClassResolver, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\RemovingStatic\UniqueObjectOrServiceDetector $uniqueObjectOrServiceDetector, \_PhpScoperb75b35f52b74\Rector\RemovingStatic\UniqueObjectFactoryFactory $uniqueObjectFactoryFactory, \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Printer\FactoryClassPrinter $factoryClassPrinter)
    {
        $this->propertyNaming = $propertyNaming;
        $this->uniqueObjectOrServiceDetector = $uniqueObjectOrServiceDetector;
        $this->uniqueObjectFactoryFactory = $uniqueObjectFactoryFactory;
        $this->factoryClassPrinter = $factoryClassPrinter;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert new X/Static::call() to factories in entities, pass them via constructor to each other', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoperb75b35f52b74;

class SomeClass
{
    public function run()
    {
        return new \_PhpScoperb75b35f52b74\AnotherClass();
    }
}
\class_alias('_PhpScoperb75b35f52b74\\SomeClass', 'SomeClass', \false);
class AnotherClass
{
    public function someFun()
    {
        return \_PhpScoperb75b35f52b74\StaticClass::staticMethod();
    }
}
\class_alias('_PhpScoperb75b35f52b74\\AnotherClass', 'AnotherClass', \false);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return $this->refactorClass($node);
        }
        foreach ($this->typesToServices as $type) {
            if (!$this->isObjectType($node->class, $type)) {
                continue;
            }
            $objectType = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($type);
            // is this object created via new somewhere else? use factory!
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $thisPropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $variableName);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($thisPropertyFetch, $node->name, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->typesToServices = $configuration[self::TYPES_TO_SERVICES] ?? [];
    }
    private function refactorClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
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
