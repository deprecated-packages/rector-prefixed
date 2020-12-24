<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\StaticTypesInClassResolver;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Depends on @see PassFactoryToUniqueObjectRector
 *
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\PassFactoryToEntityRectorTest
 */
final class NewUniqueObjectToEntityFactoryRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper0a6b37af0871\Rector\RemovingStatic\StaticTypesInClassResolver $staticTypesInClassResolver)
    {
        $this->propertyNaming = $propertyNaming;
        $this->staticTypesInClassResolver = $staticTypesInClassResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert new X to new factories', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoper0a6b37af0871;

class SomeClass
{
    public function run()
    {
        return new \_PhpScoper0a6b37af0871\AnotherClass();
    }
}
\class_alias('_PhpScoper0a6b37af0871\\SomeClass', 'SomeClass', \false);
class AnotherClass
{
    public function someFun()
    {
        return \_PhpScoper0a6b37af0871\StaticClass::staticMethod();
    }
}
\class_alias('_PhpScoper0a6b37af0871\\AnotherClass', 'AnotherClass', \false);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $this->matchedObjectTypes = [];
        // collect classes with new to factory in all classes
        $classesUsingTypes = $this->resolveClassesUsingTypes();
        $this->traverseNodesWithCallable($node->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($classesUsingTypes) : ?MethodCall {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
                return null;
            }
            $class = $this->getName($node->class);
            if ($class === null) {
                return null;
            }
            if (!\in_array($class, $classesUsingTypes, \true)) {
                return null;
            }
            $objectType = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($class);
            $this->matchedObjectTypes[] = $objectType;
            $propertyName = $this->propertyNaming->fqnToVariableName($objectType) . self::FACTORY;
            $propertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), $propertyName);
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($propertyFetch, 'create', $node->args);
        });
        foreach ($this->matchedObjectTypes as $matchedObjectType) {
            $propertyName = $this->propertyNaming->fqnToVariableName($matchedObjectType) . self::FACTORY;
            $propertyType = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($matchedObjectType->getClassName() . self::FACTORY);
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
                    throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
                }
                $this->classesUsingTypes[] = $name;
            }
        }
        $this->classesUsingTypes = (array) \array_unique($this->classesUsingTypes);
        return $this->classesUsingTypes;
    }
}
