<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
use Rector\RemovingStatic\ValueObject\PHPUnitClass;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\PHPUnitStaticToKernelTestCaseGetRectorTest
 */
final class PHPUnitStaticToKernelTestCaseGetRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming, \Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory)
    {
        $this->propertyNaming = $propertyNaming;
        $this->classInsertManipulator = $classInsertManipulator;
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert static calls in PHPUnit test cases, to get() from the container of KernelTestCase', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoper50d83356d739;

use _PhpScoper50d83356d739\PHPUnit\Framework\TestCase;
final class SomeTestCase extends \_PhpScoper50d83356d739\PHPUnit\Framework\TestCase
{
    public function test()
    {
        $product = \_PhpScoper50d83356d739\EntityFactory::create('product');
    }
}
\class_alias('_PhpScoper50d83356d739\\SomeTestCase', 'SomeTestCase', \false);
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
        return [\PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // skip yourself
        $this->newProperties = [];
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
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
    private function processClass(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\Class_
    {
        if ($this->isObjectType($class, \Rector\RemovingStatic\ValueObject\PHPUnitClass::TEST_CASE)) {
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
    private function processStaticCall(\PhpParser\Node\Expr\StaticCall $staticCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        /** @var Class_|null $classLike */
        $classLike = $staticCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        foreach ($this->staticClassTypes as $type) {
            $objectType = new \PHPStan\Type\ObjectType($type);
            if (!$this->isObjectType($staticCall->class, $objectType)) {
                continue;
            }
            return $this->convertStaticCallToPropertyMethodCall($staticCall, $objectType);
        }
        return null;
    }
    private function processPHPUnitClass(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\Class_
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
            $setupClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::SET_UP);
            // get setup or create a setup add add it there
            if ($setupClassMethod !== null) {
                $this->updateSetUpMethod($setupClassMethod, $parentSetUpStaticCallExpression, $assign);
            } else {
                $setUpMethod = $this->setUpClassMethodFactory->createSetUpMethod([$assign]);
                $this->classInsertManipulator->addAsFirstMethod($class, $setUpMethod);
            }
        }
        // update parent clsas if not already
        if (!$this->isObjectType($class, '_PhpScoper50d83356d739\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase')) {
            $class->extends = new \PhpParser\Node\Name\FullyQualified('_PhpScoper50d83356d739\\Symfony\\Bundle\\FrameworkBundle\\Test\\KernelTestCase');
        }
        return $class;
    }
    /**
     * @return ObjectType[]
     */
    private function collectNewPropertyObjectTypes(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $this->newProperties = [];
        $this->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) : void {
            if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
                return;
            }
            foreach ($this->staticClassTypes as $type) {
                $objectType = new \PHPStan\Type\ObjectType($type);
                if (!$this->isObjectType($node->class, $objectType)) {
                    continue;
                }
                $this->newProperties[] = $objectType;
            }
        });
        $this->newProperties = \array_unique($this->newProperties);
        return $this->newProperties;
    }
    private function convertStaticCallToPropertyMethodCall(\PhpParser\Node\Expr\StaticCall $staticCall, \PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Expr\MethodCall
    {
        // create "$this->someService" instead
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
        // turn static call to method on property call
        $methodCall = new \PhpParser\Node\Expr\MethodCall($propertyFetch, $staticCall->name);
        $methodCall->args = $staticCall->args;
        return $methodCall;
    }
    /**
     * @param ObjectType[] $newProperties
     */
    private function addNewPropertiesToClass(\PhpParser\Node\Stmt\Class_ $class, array $newProperties) : \PhpParser\Node\Stmt\Class_
    {
        $properties = [];
        foreach ($newProperties as $objectType) {
            $properties[] = $this->createPropertyFromType($objectType);
        }
        // add property to the start of the class
        $class->stmts = \array_merge($properties, $class->stmts);
        return $class;
    }
    private function createParentSetUpStaticCall() : \PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->createStaticCall('parent', \Rector\Core\ValueObject\MethodName::SET_UP);
        return new \PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
    private function createContainerGetTypeToPropertyAssign(\PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Stmt\Expression
    {
        $getMethodCall = $this->createContainerGetTypeMethodCall($objectType);
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
        $assign = new \PhpParser\Node\Expr\Assign($propertyFetch, $getMethodCall);
        return new \PhpParser\Node\Stmt\Expression($assign);
    }
    private function updateSetUpMethod(\PhpParser\Node\Stmt\ClassMethod $setupClassMethod, \PhpParser\Node\Stmt\Expression $parentSetupStaticCall, \PhpParser\Node\Stmt\Expression $assign) : void
    {
        $parentSetUpStaticCallPosition = $this->getParentSetUpStaticCallPosition($setupClassMethod);
        if ($parentSetUpStaticCallPosition === null) {
            $setupClassMethod->stmts = \array_merge([$parentSetupStaticCall, $assign], (array) $setupClassMethod->stmts);
        } else {
            \assert($setupClassMethod->stmts !== null);
            \array_splice($setupClassMethod->stmts, $parentSetUpStaticCallPosition + 1, 0, [$assign]);
        }
    }
    private function createPropertyFromType(\PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Stmt\Property
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        return $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $objectType);
    }
    private function createContainerGetTypeMethodCall(\PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Expr\MethodCall
    {
        $staticPropertyFetch = new \PhpParser\Node\Expr\StaticPropertyFetch(new \PhpParser\Node\Name('self'), 'container');
        $getMethodCall = new \PhpParser\Node\Expr\MethodCall($staticPropertyFetch, 'get');
        $className = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if (!$className instanceof \PhpParser\Node\Name) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $getMethodCall->args[] = new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\ClassConstFetch($className, 'class'));
        return $getMethodCall;
    }
    private function getParentSetUpStaticCallPosition(\PhpParser\Node\Stmt\ClassMethod $setupClassMethod) : ?int
    {
        foreach ((array) $setupClassMethod->stmts as $position => $methodStmt) {
            if ($methodStmt instanceof \PhpParser\Node\Stmt\Expression) {
                $methodStmt = $methodStmt->expr;
            }
            if (!$this->isStaticCallNamed($methodStmt, 'parent', \Rector\Core\ValueObject\MethodName::SET_UP)) {
                continue;
            }
            return $position;
        }
        return null;
    }
}
