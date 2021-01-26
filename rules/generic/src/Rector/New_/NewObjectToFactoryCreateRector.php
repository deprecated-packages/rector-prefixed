<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\New_;

use RectorPrefix20210126\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\NewObjectToFactoryCreateRectorTest
 */
final class NewObjectToFactoryCreateRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OBJECT_TO_FACTORY_METHOD = '$objectToFactoryMethod';
    /**
     * @var string[][]
     */
    private $objectToFactoryMethod = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces creating object instances with "new" keyword with factory method.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->objectToFactoryMethod as $object => $factoryInfo) {
            if (!$this->isObjectType($node, $object)) {
                continue;
            }
            $factoryClass = $factoryInfo['class'];
            $factoryMethod = $factoryInfo['method'];
            $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === $factoryClass) {
                continue;
            }
            /** @var Class_ $classNode */
            $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $propertyName = $this->getExistingFactoryPropertyName($classNode, $factoryClass);
            if ($propertyName === null) {
                $propertyName = $this->getFactoryPropertyName($factoryClass);
                $factoryObjectType = new \PHPStan\Type\ObjectType($factoryClass);
                $this->addConstructorDependencyToClass($classNode, $factoryObjectType, $propertyName);
            }
            return new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName), $factoryMethod, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->objectToFactoryMethod = $configuration[self::OBJECT_TO_FACTORY_METHOD] ?? [];
    }
    private function getExistingFactoryPropertyName(\PhpParser\Node\Stmt\Class_ $class, string $factoryClass) : ?string
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
        return \RectorPrefix20210126\Nette\Utils\Strings::firstLower($shortName);
    }
}
