<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\New_;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\NewObjectToFactoryCreateRectorTest
 */
final class NewObjectToFactoryCreateRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OBJECT_TO_FACTORY_METHOD = '$objectToFactoryMethod';
    /**
     * @var string[][]
     */
    private $objectToFactoryMethod = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces creating object instances with "new" keyword with factory method.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
	public function example() {
		new MyClass($argument);
	}
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
	/**
	 * @var \MyClassFactory
	 */
	private $myClassFactory;

	public function example() {
		$this->myClassFactory->create($argument);
	}
}
CODE_SAMPLE
, [self::OBJECT_TO_FACTORY_METHOD => ['MyClass' => ['class' => 'MyClassFactory', 'method' => 'create']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        foreach ($this->objectToFactoryMethod as $object => $factoryInfo) {
            if (!$this->isObjectType($node, $object)) {
                continue;
            }
            $factoryClass = $factoryInfo['class'];
            $factoryMethod = $factoryInfo['method'];
            $className = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === $factoryClass) {
                continue;
            }
            /** @var Class_ $classNode */
            $classNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $propertyName = $this->getExistingFactoryPropertyName($classNode, $factoryClass);
            if ($propertyName === null) {
                $propertyName = $this->getFactoryPropertyName($factoryClass);
                $factoryObjectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($factoryClass);
                $this->addConstructorDependencyToClass($classNode, $factoryObjectType, $propertyName);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), $propertyName), $factoryMethod, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->objectToFactoryMethod = $configuration[self::OBJECT_TO_FACTORY_METHOD] ?? [];
    }
    private function getExistingFactoryPropertyName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $factoryClass) : ?string
    {
        foreach ($class->getProperties() as $property) {
            if ($this->isObjectType($property, $factoryClass)) {
                return (string) $property->props[0]->name;
            }
        }
        return null;
    }
    private function getFactoryPropertyName(string $factoryFullQualifiedName) : string
    {
        $reflectionClass = new \ReflectionClass($factoryFullQualifiedName);
        $shortName = $reflectionClass->getShortName();
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::firstLower($shortName);
    }
}
