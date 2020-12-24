<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\SOLID\NodeFactory\InjectMethodFactory;
use _PhpScoperb75b35f52b74\Rector\SOLID\NodeRemover\ClassMethodNodeRemover;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\SOLID\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector\MultiParentingToAbstractDependencyRectorTest
 */
final class MultiParentingToAbstractDependencyRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const FRAMEWORK_SYMFONY = 'symfony';
    /**
     * @api
     * @var string
     */
    public const FRAMEWORK_NETTE = 'nette';
    /**
     * @api
     * @var string
     */
    public const FRAMEWORK = 'framework';
    /**
     * @var string
     */
    private $framework;
    /**
     * @var ObjectType[]
     */
    private $objectTypesToInject = [];
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\SOLID\NodeRemover\ClassMethodNodeRemover $classMethodNodeRemover, \_PhpScoperb75b35f52b74\Rector\SOLID\NodeFactory\InjectMethodFactory $injectMethodFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->injectMethodFactory = $injectMethodFactory;
        $this->classMethodNodeRemover = $classMethodNodeRemover;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move dependency passed to all children to parent as @inject/@required dependency', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::FRAMEWORK => self::FRAMEWORK_NETTE])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->isAbstract()) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        $childrenClasses = $this->nodeRepository->findChildrenOfClass($className);
        if (\count($childrenClasses) < 2) {
            return null;
        }
        $classMethod = $node->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            return null;
        }
        $abstractClassConstructorParamTypes = $this->resolveConstructorParamClassTypes($node);
        // process
        $this->objectTypesToInject = [];
        foreach ($childrenClasses as $childrenClass) {
            $constructorClassMethod = $childrenClass->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            if ($constructorClassMethod === null) {
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
    public function configure(array $configuration) : void
    {
        $this->framework = $configuration[self::FRAMEWORK];
    }
    /**
     * @return ObjectType[]
     */
    private function resolveConstructorParamClassTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructorClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return [];
        }
        $objectTypes = [];
        foreach ($constructorClassMethod->getParams() as $param) {
            $paramType = $this->getObjectType($param);
            $paramType = $this->popFirstObjectTypeFromUnionType($paramType);
            if (!$paramType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                continue;
            }
            $objectTypes[] = $paramType;
        }
        return $objectTypes;
    }
    /**
     * @param ObjectType[] $abstractClassConstructorParamTypes
     */
    private function refactorChildConstructorClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, array $abstractClassConstructorParamTypes) : void
    {
        foreach ($classMethod->getParams() as $key => $param) {
            $paramType = $this->getStaticType($param);
            $paramType = $this->popFirstObjectTypeFromUnionType($paramType);
            if (!$paramType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                continue;
            }
            if (!$this->isSameObjectTypes($paramType, $abstractClassConstructorParamTypes)) {
                continue;
            }
            unset($classMethod->params[$key]);
            $this->classMethodNodeRemover->removeParamFromMethodBody($classMethod, $param);
            $this->objectTypesToInject[] = $paramType;
        }
    }
    private function clearAbstractClassConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        foreach ($classMethod->getParams() as $key => $param) {
            if (!$this->isObjectTypes($param, $this->objectTypesToInject)) {
                continue;
            }
            unset($classMethod->params[$key]);
            $this->classMethodNodeRemover->removeParamFromMethodBody($classMethod, $param);
        }
        $this->classMethodNodeRemover->removeClassMethodIfUseless($classMethod);
    }
    private function addInjectOrRequiredClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($this->objectTypesToInject === []) {
            return;
        }
        $injectClassMethod = $this->injectMethodFactory->createFromTypes($this->objectTypesToInject, $className, $this->framework);
        $this->classInsertManipulator->addAsFirstMethod($class, $injectClassMethod);
    }
    private function popFirstObjectTypeFromUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $paramType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$paramType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $paramType;
        }
        foreach ($paramType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                return $unionedType;
            }
        }
        return $paramType;
    }
}
