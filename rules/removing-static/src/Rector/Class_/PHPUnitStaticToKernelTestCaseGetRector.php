<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\ValueObject\PHPUnitClass;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\PHPUnitStaticToKernelTestCaseGetRectorTest
 */
final class PHPUnitStaticToKernelTestCaseGetRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const STATIC_CLASS_TYPES = 'static_class_types';
    /**
     * @var mixed[]
     */
    private $staticClassTypes = [];
    /**
     * @var ObjectType[]
     */
    private $newProperties = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @var SetUpClassMethodFactory
     */
    private $setUpClassMethodFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory)
    {
        $this->propertyNaming = $propertyNaming;
        $this->classInsertManipulator = $classInsertManipulator;
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert static calls in PHPUnit test cases, to get() from the container of KernelTestCase', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
final class SomeTestCase extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    public function test()
    {
        $product = \_PhpScoperb75b35f52b74\EntityFactory::create('product');
    }
}
\class_alias('_PhpScoperb75b35f52b74\\SomeTestCase', 'SomeTestCase', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SomeTestCase extends KernelTestCase
{
    /**
     * @var EntityFactory
     */
    private $entityFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entityFactory = $this->getService(EntityFactory::class);
    }

    public function test()
    {
        $product = $this->entityFactory->create('product');
    }
}
CODE_SAMPLE
, [self::STATIC_CLASS_TYPES => ['EntityFactory']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // skip yourself
        $this->newProperties = [];
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            if ($this->isObjectTypes($node, $this->staticClassTypes)) {
                return null;
            }
            return $this->processClass($node);
        }
        return $this->processStaticCall($node);
    }
    public function configure(array $configuration) : void
    {
        $this->staticClassTypes = $configuration[self::STATIC_CLASS_TYPES] ?? [];
    }
    private function processClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        if ($this->isObjectType($class, \_PhpScoperb75b35f52b74\Rector\RemovingStatic\ValueObject\PHPUnitClass::TEST_CASE)) {
            return $this->processPHPUnitClass($class);
        }
        // add property with the object
        $newPropertyObjectTypes = $this->collectNewPropertyObjectTypes($class);
        if ($newPropertyObjectTypes === []) {
            return null;
        }
        // add via constructor
        foreach ($newPropertyObjectTypes as $newPropertyObjectType) {
            $newPropertyName = $this->propertyNaming->fqnToVariableName($newPropertyObjectType);
            $this->addConstructorDependencyToClass($class, $newPropertyObjectType, $newPropertyName);
        }
        return $class;
    }
    private function processStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        /** @var Class_|null $classLike */
        $classLike = $staticCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        foreach ($this->staticClassTypes as $type) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
            if (!$this->isObjectType($staticCall->class, $objectType)) {
                continue;
            }
            return $this->convertStaticCallToPropertyMethodCall($staticCall, $objectType);
        }
        return null;
    }
    private function processPHPUnitClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        // add property with the object
        $newPropertyTypes = $this->collectNewPropertyObjectTypes($class);
        if ($newPropertyTypes === []) {
            return null;
        }
        // add all properties to class
        $class = $this->addNewPropertiesToClass($class, $newPropertyTypes);
        $parentSetUpStaticCallExpression = $this->createParentSetUpStaticCall();
        foreach ($newPropertyTypes as $type) {
            // container fetch assign
            $assign = $this->createContainerGetTypeToPropertyAssign($type);
            $setupClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
            // get setup or create a setup add add it there
            if ($setupClassMethod !== null) {
                $this->updateSetUpMethod($setupClassMethod, $parentSetUpStaticCallExpression, $assign);
            } else {
                $setUpMethod = $this->setUpClassMethodFactory->createSetUpMethod([$assign]);
                $this->classInsertManipulator->addAsFirstMethod($class, $setUpMethod);
            }
        }
        // update parent clsas if not already
        if (!$this->isObjectType($class, '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
            $class->extends = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase');
        }
        return $class;
    }
    /**
     * @return ObjectType[]
     */
    private function collectNewPropertyObjectTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $this->newProperties = [];
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
                return;
            }
            foreach ($this->staticClassTypes as $type) {
                $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
                if (!$this->isObjectType($node->class, $objectType)) {
                    continue;
                }
                $this->newProperties[] = $objectType;
            }
        });
        $this->newProperties = \array_unique($this->newProperties);
        return $this->newProperties;
    }
    private function convertStaticCallToPropertyMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        // create "$this->someService" instead
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
        // turn static call to method on property call
        $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($propertyFetch, $staticCall->name);
        $methodCall->args = $staticCall->args;
        return $methodCall;
    }
    /**
     * @param ObjectType[] $newProperties
     */
    private function addNewPropertiesToClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $newProperties) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        $properties = [];
        foreach ($newProperties as $objectType) {
            $properties[] = $this->createPropertyFromType($objectType);
        }
        // add property to the start of the class
        $class->stmts = \array_merge($properties, $class->stmts);
        return $class;
    }
    private function createParentSetUpStaticCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->createStaticCall('parent', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
    private function createContainerGetTypeToPropertyAssign(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $getMethodCall = $this->createContainerGetTypeMethodCall($objectType);
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $getMethodCall);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
    }
    private function updateSetUpMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $setupClassMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $parentSetupStaticCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $assign) : void
    {
        $parentSetUpStaticCallPosition = $this->getParentSetUpStaticCallPosition($setupClassMethod);
        if ($parentSetUpStaticCallPosition === null) {
            $setupClassMethod->stmts = \array_merge([$parentSetupStaticCall, $assign], (array) $setupClassMethod->stmts);
        } else {
            \assert($setupClassMethod->stmts !== null);
            \array_splice($setupClassMethod->stmts, $parentSetUpStaticCallPosition + 1, 0, [$assign]);
        }
    }
    private function createPropertyFromType(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        return $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $objectType);
    }
    private function createContainerGetTypeMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $staticPropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self'), 'container');
        $getMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($staticPropertyFetch, 'get');
        $className = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if (!$className instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $getMethodCall->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch($className, 'class'));
        return $getMethodCall;
    }
    private function getParentSetUpStaticCallPosition(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $setupClassMethod) : ?int
    {
        foreach ((array) $setupClassMethod->stmts as $position => $methodStmt) {
            if ($methodStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                $methodStmt = $methodStmt->expr;
            }
            if (!$this->isStaticCallNamed($methodStmt, 'parent', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP)) {
                continue;
            }
            return $position;
        }
        return null;
    }
}
