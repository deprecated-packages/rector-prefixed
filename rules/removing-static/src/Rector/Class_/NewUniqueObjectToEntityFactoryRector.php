<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\RemovingStatic\StaticTypesInClassResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Depends on @see PassFactoryToUniqueObjectRector
 *
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\PassFactoryToEntityRectorTest
 */
final class NewUniqueObjectToEntityFactoryRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const TYPES_TO_SERVICES = '$typesToServices';
    /**
     * @var string
     */
    private const FACTORY = 'Factory';
    /**
     * @var ObjectType[]
     */
    private $matchedObjectTypes = [];
    /**
     * @var string[]
     */
    private $typesToServices = [];
    /**
     * @var string[]
     */
    private $classesUsingTypes = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var StaticTypesInClassResolver
     */
    private $staticTypesInClassResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScopere8e811afab72\Rector\RemovingStatic\StaticTypesInClassResolver $staticTypesInClassResolver)
    {
        $this->propertyNaming = $propertyNaming;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert new X to new factories', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
    public function someFun()
    {
        return StaticClass::staticMethod();
    }
}
CODE_SAMPLE
, [self::TYPES_TO_SERVICES => ['ClassName']])]);
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
        $this->matchedObjectTypes = [];
        // collect classes with new to factory in all classes
        $classesUsingTypes = $this->resolveClassesUsingTypes();
        $this->traverseNodesWithCallable($node->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($classesUsingTypes) : ?MethodCall {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
                return null;
            }
            $class = $this->getName($node->class);
            if ($class === null) {
                return null;
            }
            if (!\in_array($class, $classesUsingTypes, \true)) {
                return null;
            }
            $objectType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($class);
            $this->matchedObjectTypes[] = $objectType;
            $propertyName = $this->propertyNaming->fqnToVariableName($objectType) . self::FACTORY;
            $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $propertyName);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, 'create', $node->args);
        });
        foreach ($this->matchedObjectTypes as $matchedObjectType) {
            $propertyName = $this->propertyNaming->fqnToVariableName($matchedObjectType) . self::FACTORY;
            $propertyType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($matchedObjectType->getClassName() . self::FACTORY);
            $this->addConstructorDependencyToClass($node, $propertyType, $propertyName);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->typesToServices = $configuration[self::TYPES_TO_SERVICES] ?? [];
    }
    /**
     * @return string[]
     */
    private function resolveClassesUsingTypes() : array
    {
        if ($this->classesUsingTypes !== []) {
            return $this->classesUsingTypes;
        }
        // temporary
        $classes = $this->parsedNodeCollector->getClasses();
        if ($classes === []) {
            return [];
        }
        foreach ($classes as $class) {
            $hasTypes = (bool) $this->staticTypesInClassResolver->collectStaticCallTypeInClass($class, $this->typesToServices);
            if ($hasTypes) {
                $name = $this->getName($class);
                if ($name === null) {
                    throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
                }
                $this->classesUsingTypes[] = $name;
            }
        }
        $this->classesUsingTypes = (array) \array_unique($this->classesUsingTypes);
        return $this->classesUsingTypes;
    }
}
