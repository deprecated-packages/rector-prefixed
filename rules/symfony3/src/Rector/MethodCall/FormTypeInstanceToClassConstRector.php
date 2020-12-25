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
use Rector\Core\ValueObject\MethodName;
use Rector\Symfony3\NodeFactory\BuilderFormNodeFactory;
use Rector\Symfony3\NodeFactory\ConfigureOptionsNodeFactory;
use ReflectionClass;
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
 * @see \Rector\Symfony3\Tests\Rector\MethodCall\FormTypeInstanceToClassConstRector\FormTypeInstanceToClassConstRectorTest
 */
final class FormTypeInstanceToClassConstRector extends \Rector\Symfony3\Rector\MethodCall\AbstractFormAddRector
{
    /**
     * @var string[]
     */
    private const CONTROLLER_TYPES = ['_PhpScoper567b66d83109\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller', '_PhpScoper567b66d83109\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController'];
    /**
     * @var BuilderFormNodeFactory
     */
    private $builderFormNodeFactory;
    /**
     * @var ConfigureOptionsNodeFactory
     */
    private $configureOptionsNodeFactory;
    public function __construct(\Rector\Symfony3\NodeFactory\BuilderFormNodeFactory $builderFormNodeFactory, \Rector\Symfony3\NodeFactory\ConfigureOptionsNodeFactory $configureOptionsNodeFactory)
    {
        $this->builderFormNodeFactory = $builderFormNodeFactory;
        $this->configureOptionsNodeFactory = $configureOptionsNodeFactory;
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->isObjectTypes($node->var, self::CONTROLLER_TYPES) && $this->isName($node->name, 'createForm')) {
            return $this->processNewInstance($node, 0, 2);
        }
        if (!$this->isFormAddMethodCall($node)) {
            return null;
        }
        // special case for collections
        if ($this->isCollectionType($node)) {
            $this->refactorCollectionOptions($node);
        }
        return $this->processNewInstance($node, 1, 2);
    }
    private function processNewInstance(\PhpParser\Node\Expr\MethodCall $methodCall, int $position, int $optionsPosition) : ?\PhpParser\Node
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
            if ($methodCall === null) {
                return null;
            }
        }
        $methodCall->args[$position]->value = $this->createClassConstantReference($argValue->class->toString());
        return $methodCall;
    }
    private function refactorCollectionOptions(\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $optionsArray = $this->matchOptionsArray($methodCall);
        if ($optionsArray === null) {
            return;
        }
        foreach ($optionsArray->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if ($arrayItem->key === null) {
                continue;
            }
            if (!$this->isValues($arrayItem->key, ['entry', 'entry_type'])) {
                continue;
            }
            if (!$arrayItem->value instanceof \PhpParser\Node\Expr\New_) {
                continue;
            }
            $newClass = $arrayItem->value->class;
            if (!$newClass instanceof \PhpParser\Node\Name) {
                continue;
            }
            $arrayItem->value = $this->createClassConstantReference($newClass->toString());
        }
    }
    /**
     * @param Arg[] $argNodes
     */
    private function moveArgumentsToOptions(\PhpParser\Node\Expr\MethodCall $methodCall, int $position, int $optionsPosition, string $className, array $argNodes) : ?\PhpParser\Node\Expr\MethodCall
    {
        $namesToArgs = $this->resolveNamesToArgs($className, $argNodes);
        // set default data in between
        if ($position + 1 !== $optionsPosition && !isset($methodCall->args[$position + 1])) {
            $methodCall->args[$position + 1] = new \PhpParser\Node\Arg($this->createNull());
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
        if ($formTypeClass === null) {
            return null;
        }
        $constructorClassMethod = $formTypeClass->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        // nothing we can do, out of scope
        if ($constructorClassMethod === null) {
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
     */
    private function resolveNamesToArgs(string $className, array $argNodes) : array
    {
        $reflectionClass = new \ReflectionClass($className);
        $constructorReflectionMethod = $reflectionClass->getConstructor();
        if ($constructorReflectionMethod === null) {
            return [];
        }
        $namesToArgs = [];
        foreach ($constructorReflectionMethod->getParameters() as $reflectionParameter) {
            $namesToArgs[$reflectionParameter->getName()] = $argNodes[$reflectionParameter->getPosition()];
        }
        return $namesToArgs;
    }
    private function addBuildFormMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $buildFormClassMethod = $class->getMethod('buildForm');
        if ($buildFormClassMethod !== null) {
            return;
        }
        $class->stmts[] = $this->builderFormNodeFactory->create($classMethod);
    }
    /**
     * @param Arg[] $namesToArgs
     */
    private function addConfigureOptionsMethod(\PhpParser\Node\Stmt\Class_ $class, array $namesToArgs) : void
    {
        $configureOptionsClassMethod = $class->getMethod('configureOptions');
        if ($configureOptionsClassMethod !== null) {
            return;
        }
        $class->stmts[] = $this->configureOptionsNodeFactory->create($namesToArgs);
    }
}
