<?php

declare (strict_types=1);
namespace Rector\Privatization\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\NodeManipulator\ClassMethodAssignManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\PropertyToAddCollector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\ChangeReadOnlyVariableWithDefaultValueToConstantRectorTest
 */
final class ChangeReadOnlyVariableWithDefaultValueToConstantRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodAssignManipulator
     */
    private $classMethodAssignManipulator;
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    /**
     * @var PropertyToAddCollector
     */
    private $propertyToAddCollector;
    /**
     * @param \Rector\Core\NodeManipulator\ClassMethodAssignManipulator $classMethodAssignManipulator
     * @param \Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator
     * @param \Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector
     */
    public function __construct($classMethodAssignManipulator, $varAnnotationManipulator, $propertyToAddCollector)
    {
        $this->classMethodAssignManipulator = $classMethodAssignManipulator;
        $this->varAnnotationManipulator = $varAnnotationManipulator;
        $this->propertyToAddCollector = $propertyToAddCollector;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change variable with read only status with default value to constant', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $replacements = [
            'PHPUnit\Framework\TestCase\Notice' => 'expectNotice',
            'PHPUnit\Framework\TestCase\Deprecated' => 'expectDeprecation',
        ];

        foreach ($replacements as $class => $method) {
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string[]
     */
    private const REPLACEMENTS = [
        'PHPUnit\Framework\TestCase\Notice' => 'expectNotice',
        'PHPUnit\Framework\TestCase\Deprecated' => 'expectDeprecation',
    ];

    public function run()
    {
        foreach (self::REPLACEMENTS as $class => $method) {
        }
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $readOnlyVariableAssigns = $this->collectReadOnlyVariableAssigns($node);
        $readOnlyVariableAssigns = $this->filterOutUniqueNames($readOnlyVariableAssigns);
        if ($readOnlyVariableAssigns === []) {
            return null;
        }
        foreach ($readOnlyVariableAssigns as $readOnlyVariable) {
            $methodName = $readOnlyVariable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if (!\is_string($methodName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $classMethod = $node->getMethod($methodName);
            if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->refactorClassMethod($classMethod, $node, $readOnlyVariableAssigns);
        }
        return $node;
    }
    /**
     * @return Assign[]
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function collectReadOnlyVariableAssigns($class) : array
    {
        $readOnlyVariables = [];
        foreach ($class->getMethods() as $classMethod) {
            if ($this->isFoundByRefParam($classMethod)) {
                return [];
            }
            $readOnlyVariableAssignScalarVariables = $this->classMethodAssignManipulator->collectReadyOnlyAssignScalarVariables($classMethod);
            $readOnlyVariables = \array_merge($readOnlyVariables, $readOnlyVariableAssignScalarVariables);
        }
        return $readOnlyVariables;
    }
    /**
     * @param Assign[] $assigns
     * @return Assign[]
     */
    private function filterOutUniqueNames($assigns) : array
    {
        $assignsByName = $this->collectAssignsByName($assigns);
        $assignsWithUniqueName = [];
        /** @var Assign[] $assignByName */
        foreach ($assignsByName as $assignByName) {
            $count = \count($assignByName);
            if ($count > 1) {
                continue;
            }
            $assignsWithUniqueName = \array_merge($assignsWithUniqueName, $assignByName);
        }
        return $assignsWithUniqueName;
    }
    /**
     * @param Assign[] $assigns
     * @return array<string, Assign[]>
     */
    private function collectAssignsByName($assigns) : array
    {
        $assignsByName = [];
        foreach ($assigns as $assign) {
            /** @var string $variableName */
            $variableName = $this->getName($assign->var);
            $assignsByName[$variableName][] = $assign;
        }
        return $assignsByName;
    }
    /**
     * @param Assign[] $readOnlyVariableAssigns
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function refactorClassMethod($classMethod, $class, $readOnlyVariableAssigns) : void
    {
        foreach ($readOnlyVariableAssigns as $readOnlyVariableAssign) {
            $this->removeNode($readOnlyVariableAssign);
            /** @var Variable|ClassConstFetch $variable */
            $variable = $readOnlyVariableAssign->var;
            // already overridden
            if (!$variable instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            $classConst = $this->createPrivateClassConst($variable, $readOnlyVariableAssign->expr);
            // replace $variable usage in the code with constant
            $this->propertyToAddCollector->addConstantToClass($class, $classConst);
            $variableName = $this->getName($variable);
            if ($variableName === null) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->replaceVariableWithClassConstFetch($classMethod, $variableName, $classConst);
        }
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function isFoundByRefParam($classMethod) : bool
    {
        $params = $classMethod->getParams();
        foreach ($params as $param) {
            if ($param->byRef) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node\Expr\Variable $variable
     * @param \PhpParser\Node\Expr $expr
     */
    private function createPrivateClassConst($variable, $expr) : \PhpParser\Node\Stmt\ClassConst
    {
        $constantName = $this->createConstantNameFromVariable($variable);
        $const = new \PhpParser\Node\Const_($constantName, $expr);
        $classConst = new \PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
        $this->mirrorComments($classConst, $variable);
        $constantType = $this->getStaticType($classConst->consts[0]->value);
        $this->varAnnotationManipulator->decorateNodeWithType($classConst, $constantType);
        return $classConst;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param string $variableName
     * @param \PhpParser\Node\Stmt\ClassConst $classConst
     */
    private function replaceVariableWithClassConstFetch($classMethod, $variableName, $classConst) : void
    {
        $constantName = $this->getName($classConst);
        if ($constantName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) use($variableName, $constantName) : ?ClassConstFetch {
            if (!$this->nodeNameResolver->isVariableName($node, $variableName)) {
                return null;
            }
            // replace with constant fetch
            $classConstFetch = new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name('self'), new \PhpParser\Node\Identifier($constantName));
            // needed later
            $classConstFetch->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME));
            return $classConstFetch;
        });
    }
    /**
     * @param \PhpParser\Node\Expr\Variable $variable
     */
    private function createConstantNameFromVariable($variable) : string
    {
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $constantName = \Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($variableName);
        return \strtoupper($constantName);
    }
}
