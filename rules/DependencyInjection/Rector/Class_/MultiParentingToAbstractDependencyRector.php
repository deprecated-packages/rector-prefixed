<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\NodeManipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\FrameworkName;
use Rector\Core\ValueObject\MethodName;
use Rector\DependencyInjection\NodeFactory\InjectMethodFactory;
use Rector\DependencyInjection\NodeRemover\ClassMethodNodeRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector\MultiParentingToAbstractDependencyRectorTest
 */
final class MultiParentingToAbstractDependencyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    const FRAMEWORK = 'framework';
    /**
     * @var string
     */
    private $framework;
    /**
     * @var ObjectType[]
     */
    private $injectObjectTypes = [];
    /**
     * @var ClassMethodNodeRemover
     */
    private $classMethodNodeRemover;
    /**
     * @var InjectMethodFactory
     */
    private $injectMethodFactory;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\Rector\DependencyInjection\NodeRemover\ClassMethodNodeRemover $classMethodNodeRemover, \Rector\DependencyInjection\NodeFactory\InjectMethodFactory $injectMethodFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\Core\NodeManipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->injectMethodFactory = $injectMethodFactory;
        $this->classMethodNodeRemover = $classMethodNodeRemover;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move dependency passed to all children to parent as @inject/@required dependency', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
abstract class AbstractParentClass
{
    private $someDependency;

    public function __construct(SomeDependency $someDependency)
    {
        $this->someDependency = $someDependency;
    }
}

class FirstChild extends AbstractParentClass
{
    public function __construct(SomeDependency $someDependency)
    {
        parent::__construct($someDependency);
    }
}

class SecondChild extends AbstractParentClass
{
    public function __construct(SomeDependency $someDependency)
    {
        parent::__construct($someDependency);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
abstract class AbstractParentClass
{
    /**
     * @inject
     * @var SomeDependency
     */
    public $someDependency;
}

class FirstChild extends AbstractParentClass
{
}

class SecondChild extends AbstractParentClass
{
}
CODE_SAMPLE
, [self::FRAMEWORK => \Rector\Core\ValueObject\FrameworkName::NETTE])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        if (!$node->isAbstract()) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        $childrenClasses = $this->nodeRepository->findChildrenOfClass($className);
        if (\count($childrenClasses) < 2) {
            return null;
        }
        $classMethod = $node->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $abstractClassConstructorParamTypes = $this->resolveConstructorParamClassTypes($node);
        // process
        $this->injectObjectTypes = [];
        foreach ($childrenClasses as $childClass) {
            $constructorClassMethod = $childClass->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            $this->refactorChildConstructorClassMethod($constructorClassMethod, $abstractClassConstructorParamTypes);
            $this->classMethodNodeRemover->removeClassMethodIfUseless($constructorClassMethod);
        }
        // 2. remove from abstract class
        $this->clearAbstractClassConstructor($classMethod);
        // 3. add inject*/@required to abstract property
        $this->addInjectOrRequiredClassMethod($node);
        return $node;
    }
    /**
     * @param array<string, string> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->framework = $configuration[self::FRAMEWORK];
    }
    /**
     * @return ObjectType[]
     */
    private function resolveConstructorParamClassTypes(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructorClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        $objectTypes = [];
        foreach ($constructorClassMethod->getParams() as $param) {
            $paramType = $this->getObjectType($param);
            $paramType = $this->popFirstObjectTypeFromUnionType($paramType);
            if (!$paramType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            $objectTypes[] = $paramType;
        }
        return $objectTypes;
    }
    /**
     * @param ObjectType[] $abstractClassConstructorParamTypes
     * @return void
     */
    private function refactorChildConstructorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $abstractClassConstructorParamTypes)
    {
        foreach ($classMethod->getParams() as $key => $param) {
            $paramType = $this->getStaticType($param);
            $paramType = $this->popFirstObjectTypeFromUnionType($paramType);
            if (!$paramType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            if (!$this->nodeTypeResolver->isSameObjectTypes($paramType, $abstractClassConstructorParamTypes)) {
                continue;
            }
            $this->nodeRemover->removeParam($classMethod, $key);
            $this->classMethodNodeRemover->removeParamFromMethodBody($classMethod, $param);
            $this->injectObjectTypes[] = $paramType;
        }
    }
    /**
     * @return void
     */
    private function clearAbstractClassConstructor(\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        foreach ($classMethod->getParams() as $key => $param) {
            if (!$this->nodeTypeResolver->isObjectTypes($param, $this->injectObjectTypes)) {
                continue;
            }
            unset($classMethod->params[$key]);
            $this->classMethodNodeRemover->removeParamFromMethodBody($classMethod, $param);
        }
        $this->classMethodNodeRemover->removeClassMethodIfUseless($classMethod);
    }
    /**
     * @return void
     */
    private function addInjectOrRequiredClassMethod(\PhpParser\Node\Stmt\Class_ $class)
    {
        /** @var string $className */
        $className = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($this->injectObjectTypes === []) {
            return;
        }
        $injectClassMethod = $this->injectMethodFactory->createFromTypes($this->injectObjectTypes, $className, $this->framework);
        $this->classInsertManipulator->addAsFirstMethod($class, $injectClassMethod);
    }
    private function popFirstObjectTypeFromUnionType(\PHPStan\Type\Type $paramType) : \PHPStan\Type\Type
    {
        if (!$paramType instanceof \PHPStan\Type\UnionType) {
            return $paramType;
        }
        foreach ($paramType->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\ObjectType) {
                return $unionedType;
            }
        }
        return $paramType;
    }
}
