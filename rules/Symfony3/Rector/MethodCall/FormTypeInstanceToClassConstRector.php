<?php

declare (strict_types=1);
namespace Rector\Symfony3\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Symfony3\NodeAnalyzer\FormAddMethodCallAnalyzer;
use Rector\Symfony3\NodeAnalyzer\FormCollectionAnalyzer;
use Rector\Symfony3\NodeAnalyzer\FormOptionsArrayMatcher;
use Rector\Symfony3\NodeFactory\BuilderFormNodeFactory;
use Rector\Symfony3\NodeFactory\ConfigureOptionsNodeFactory;
use ReflectionMethod;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Best resource with clear example:
 * @see https://stackoverflow.com/questions/34027711/passing-data-to-buildform-in-symfony-2-8-3-0
 *
 * @see https://github.com/symfony/symfony/commit/adf20c86fb0d8dc2859aa0d2821fe339d3551347
 * @see http://www.keganv.com/passing-arguments-controller-file-type-symfony-3/
 * @see https://github.com/symfony/symfony/blob/2.8/UPGRADE-2.8.md#form
 *
 * @see \Rector\Tests\Symfony3\Rector\MethodCall\FormTypeInstanceToClassConstRector\FormTypeInstanceToClassConstRectorTest
 */
final class FormTypeInstanceToClassConstRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $controllerObjectTypes = [];
    /**
     * @var BuilderFormNodeFactory
     */
    private $builderFormNodeFactory;
    /**
     * @var ConfigureOptionsNodeFactory
     */
    private $configureOptionsNodeFactory;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var FormAddMethodCallAnalyzer
     */
    private $formAddMethodCallAnalyzer;
    /**
     * @var FormOptionsArrayMatcher
     */
    private $formOptionsArrayMatcher;
    /**
     * @var FormCollectionAnalyzer
     */
    private $formCollectionAnalyzer;
    public function __construct(\Rector\Symfony3\NodeFactory\BuilderFormNodeFactory $builderFormNodeFactory, \Rector\Symfony3\NodeFactory\ConfigureOptionsNodeFactory $configureOptionsNodeFactory, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\Symfony3\NodeAnalyzer\FormAddMethodCallAnalyzer $formAddMethodCallAnalyzer, \Rector\Symfony3\NodeAnalyzer\FormOptionsArrayMatcher $formOptionsArrayMatcher, \Rector\Symfony3\NodeAnalyzer\FormCollectionAnalyzer $formCollectionAnalyzer)
    {
        $this->builderFormNodeFactory = $builderFormNodeFactory;
        $this->configureOptionsNodeFactory = $configureOptionsNodeFactory;
        $this->reflectionProvider = $reflectionProvider;
        $this->formAddMethodCallAnalyzer = $formAddMethodCallAnalyzer;
        $this->formOptionsArrayMatcher = $formOptionsArrayMatcher;
        $this->controllerObjectTypes = [new \PHPStan\Type\ObjectType('Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller'), new \PHPStan\Type\ObjectType('Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')];
        $this->formCollectionAnalyzer = $formCollectionAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes createForm(new FormType), add(new FormType) to ones with "FormType::class"', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function action()
    {
        $form = $this->createForm(new TeamType, $entity);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController
{
    public function action()
    {
        $form = $this->createForm(TeamType::class, $entity);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if ($this->nodeTypeResolver->isObjectTypes($node->var, $this->controllerObjectTypes) && $this->isName($node->name, 'createForm')) {
            return $this->processNewInstance($node, 0, 2);
        }
        if (!$this->formAddMethodCallAnalyzer->matches($node)) {
            return null;
        }
        // special case for collections
        if ($this->formCollectionAnalyzer->isCollectionType($node)) {
            $this->refactorCollectionOptions($node);
        }
        return $this->processNewInstance($node, 1, 2);
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     * @param int $position
     * @param int $optionsPosition
     */
    private function processNewInstance($methodCall, $position, $optionsPosition) : ?\PhpParser\Node
    {
        if (!isset($methodCall->args[$position])) {
            return null;
        }
        $argValue = $methodCall->args[$position]->value;
        if (!$argValue instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        // we can only process direct name
        if (!$argValue->class instanceof \PhpParser\Node\Name) {
            return null;
        }
        if ($argValue->args !== []) {
            $methodCall = $this->moveArgumentsToOptions($methodCall, $position, $optionsPosition, $argValue->class->toString(), $argValue->args);
            if (!$methodCall instanceof \PhpParser\Node\Expr\MethodCall) {
                return null;
            }
        }
        $methodCall->args[$position]->value = $this->nodeFactory->createClassConstReference($argValue->class->toString());
        return $methodCall;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function refactorCollectionOptions($methodCall) : void
    {
        $optionsArray = $this->formOptionsArrayMatcher->match($methodCall);
        if (!$optionsArray instanceof \PhpParser\Node\Expr\Array_) {
            return;
        }
        foreach ($optionsArray->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if ($arrayItem->key === null) {
                continue;
            }
            if (!$this->valueResolver->isValues($arrayItem->key, ['entry', 'entry_type'])) {
                continue;
            }
            if (!$arrayItem->value instanceof \PhpParser\Node\Expr\New_) {
                continue;
            }
            $newClass = $arrayItem->value->class;
            if (!$newClass instanceof \PhpParser\Node\Name) {
                continue;
            }
            $arrayItem->value = $this->nodeFactory->createClassConstReference($newClass->toString());
        }
    }
    /**
     * @param Arg[] $argNodes
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     * @param int $position
     * @param int $optionsPosition
     * @param string $className
     */
    private function moveArgumentsToOptions($methodCall, $position, $optionsPosition, $className, $argNodes) : ?\PhpParser\Node\Expr\MethodCall
    {
        $namesToArgs = $this->resolveNamesToArgs($className, $argNodes);
        // set default data in between
        if ($position + 1 !== $optionsPosition && !isset($methodCall->args[$position + 1])) {
            $methodCall->args[$position + 1] = new \PhpParser\Node\Arg($this->nodeFactory->createNull());
        }
        // @todo decopule and name, so I know what it is
        if (!isset($methodCall->args[$optionsPosition])) {
            $array = new \PhpParser\Node\Expr\Array_();
            foreach ($namesToArgs as $name => $arg) {
                $array->items[] = new \PhpParser\Node\Expr\ArrayItem($arg->value, new \PhpParser\Node\Scalar\String_($name));
            }
            $methodCall->args[$optionsPosition] = new \PhpParser\Node\Arg($array);
        }
        $formTypeClass = $this->nodeRepository->findClass($className);
        if (!$formTypeClass instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $constructorClassMethod = $formTypeClass->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        // nothing we can do, out of scope
        if (!$constructorClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $this->addBuildFormMethod($formTypeClass, $constructorClassMethod);
        $this->addConfigureOptionsMethod($formTypeClass, $namesToArgs);
        // remove ctor
        $this->removeNode($constructorClassMethod);
        return $methodCall;
    }
    /**
     * @param Arg[] $argNodes
     * @return Arg[]
     * @param string $className
     */
    private function resolveNamesToArgs($className, $argNodes) : array
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        $reflectionClass = $classReflection->getNativeReflection();
        $constructorReflectionMethod = $reflectionClass->getConstructor();
        if (!$constructorReflectionMethod instanceof \ReflectionMethod) {
            return [];
        }
        $namesToArgs = [];
        foreach ($constructorReflectionMethod->getParameters() as $position => $reflectionParameter) {
            $namesToArgs[$reflectionParameter->getName()] = $argNodes[$position];
        }
        return $namesToArgs;
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function addBuildFormMethod($class, $classMethod) : void
    {
        $buildFormClassMethod = $class->getMethod('buildForm');
        if ($buildFormClassMethod !== null) {
            return;
        }
        $class->stmts[] = $this->builderFormNodeFactory->create($classMethod);
    }
    /**
     * @param Arg[] $namesToArgs
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function addConfigureOptionsMethod($class, $namesToArgs) : void
    {
        $configureOptionsClassMethod = $class->getMethod('configureOptions');
        if ($configureOptionsClassMethod !== null) {
            return;
        }
        $class->stmts[] = $this->configureOptionsNodeFactory->create($namesToArgs);
    }
}
