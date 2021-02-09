<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\New_;

use RectorPrefix20210209\Nette\Utils\Strings;
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
use Rector\Transform\ValueObject\NewToMethodCall;
use ReflectionClass;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210209\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\NewToMethodCallRectorTest
 */
final class NewToMethodCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const NEWS_TO_METHOD_CALLS = 'news_to_method_calls';
    /**
     * @var NewToMethodCall[]
     */
    private $newsToMethodCalls = [];
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
, [self::NEWS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\NewToMethodCall('MyClass', 'MyClassFactory', 'create')]])]);
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
        foreach ($this->newsToMethodCalls as $newToMethodCall) {
            if (!$this->isObjectType($node, $newToMethodCall->getNewType())) {
                continue;
            }
            $serviceType = $newToMethodCall->getServiceType();
            $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === $serviceType) {
                continue;
            }
            /** @var Class_ $classNode */
            $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $propertyName = $this->getExistingFactoryPropertyName($classNode, $serviceType);
            if ($propertyName === null) {
                $propertyName = $this->getFactoryPropertyName($serviceType);
                $factoryObjectType = new \PHPStan\Type\ObjectType($serviceType);
                $this->addConstructorDependencyToClass($classNode, $factoryObjectType, $propertyName);
            }
            $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
            return new \PhpParser\Node\Expr\MethodCall($propertyFetch, $newToMethodCall->getServiceMethod(), $node->args);
        }
        return $node;
    }
    /**
     * @param array<string, NewToMethodCall[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $newsToMethodCalls = $configuration[self::NEWS_TO_METHOD_CALLS] ?? [];
        \RectorPrefix20210209\Webmozart\Assert\Assert::allIsInstanceOf($newsToMethodCalls, \Rector\Transform\ValueObject\NewToMethodCall::class);
        $this->newsToMethodCalls = $newsToMethodCalls;
    }
    private function getExistingFactoryPropertyName(\PhpParser\Node\Stmt\Class_ $class, string $factoryClass) : ?string
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->isObjectType($property, $factoryClass)) {
                continue;
            }
            return $this->getName($property);
        }
        return null;
    }
    private function getFactoryPropertyName(string $factoryFullQualifiedName) : string
    {
        $reflectionClass = new \ReflectionClass($factoryFullQualifiedName);
        $shortName = $reflectionClass->getShortName();
        return \RectorPrefix20210209\Nette\Utils\Strings::firstLower($shortName);
    }
}
