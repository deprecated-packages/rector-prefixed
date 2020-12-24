<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\New_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\NewObjectToFactoryCreateRectorTest
 */
final class NewObjectToFactoryCreateRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OBJECT_TO_FACTORY_METHOD = '$objectToFactoryMethod';
    /**
     * @var string[][]
     */
    private $objectToFactoryMethod = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces creating object instances with "new" keyword with factory method.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->objectToFactoryMethod as $object => $factoryInfo) {
            if (!$this->isObjectType($node, $object)) {
                continue;
            }
            $factoryClass = $factoryInfo['class'];
            $factoryMethod = $factoryInfo['method'];
            $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === $factoryClass) {
                continue;
            }
            /** @var Class_ $classNode */
            $classNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $propertyName = $this->getExistingFactoryPropertyName($classNode, $factoryClass);
            if ($propertyName === null) {
                $propertyName = $this->getFactoryPropertyName($factoryClass);
                $factoryObjectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($factoryClass);
                $this->addConstructorDependencyToClass($classNode, $factoryObjectType, $propertyName);
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName), $factoryMethod, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->objectToFactoryMethod = $configuration[self::OBJECT_TO_FACTORY_METHOD] ?? [];
    }
    private function getExistingFactoryPropertyName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $factoryClass) : ?string
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
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::firstLower($shortName);
    }
}
