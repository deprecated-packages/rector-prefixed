<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Const_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\ChangeReadOnlyVariableWithDefaultValueToConstantRectorTest
 */
final class ChangeReadOnlyVariableWithDefaultValueToConstantRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodAssignManipulator
     */
    private $classMethodAssignManipulator;
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator $classMethodAssignManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator)
    {
        $this->classMethodAssignManipulator = $classMethodAssignManipulator;
        $this->varAnnotationManipulator = $varAnnotationManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change variable with read only status with default value to constant', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $readOnlyVariableAssigns = $this->collectReadOnlyVariableAssigns($node);
        $readOnlyVariableAssigns = $this->filterOutUniqueNames($readOnlyVariableAssigns);
        if ($readOnlyVariableAssigns === []) {
            return null;
        }
        foreach ($readOnlyVariableAssigns as $readOnlyVariable) {
            $methodName = $readOnlyVariable->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if (!\is_string($methodName)) {
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
            }
            $classMethod = $node->getMethod($methodName);
            if ($classMethod === null) {
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->refactorClassMethod($classMethod, $node, $readOnlyVariableAssigns);
        }
        return $node;
    }
    /**
     * @return Assign[]
     */
    private function collectReadOnlyVariableAssigns(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : array
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
    private function filterOutUniqueNames(array $assigns) : array
    {
        $assignsByName = [];
        foreach ($assigns as $assign) {
            /** @var string $variableName */
            $variableName = $this->getName($assign->var);
            $assignsByName[$variableName][] = $assign;
        }
        $assignsWithUniqueName = [];
        foreach ($assignsByName as $assigns) {
            if (\count($assigns) > 1) {
                continue;
            }
            $assignsWithUniqueName = \array_merge($assignsWithUniqueName, $assigns);
        }
        return $assignsWithUniqueName;
    }
    /**
     * @param Assign[] $readOnlyVariableAssigns
     */
    private function refactorClassMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, array $readOnlyVariableAssigns) : void
    {
        foreach ($readOnlyVariableAssigns as $readOnlyVariableAssign) {
            $this->removeNode($readOnlyVariableAssign);
            /** @var Variable|ClassConstFetch $variable */
            $variable = $readOnlyVariableAssign->var;
            // already overridden
            if (!$variable instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                continue;
            }
            $classConst = $this->createPrivateClassConst($variable, $readOnlyVariableAssign->expr);
            // replace $variable usage in the code with constant
            $this->addConstantToClass($class, $classConst);
            $variableName = $this->getName($variable);
            if ($variableName === null) {
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->replaceVariableWithClassConstFetch($classMethod, $variableName, $classConst);
        }
    }
    private function isFoundByRefParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $params = $classMethod->getParams();
        foreach ($params as $param) {
            if ($param->byRef) {
                return \true;
            }
        }
        return \false;
    }
    private function createPrivateClassConst(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst
    {
        $constantName = $this->createConstantNameFromVariable($variable);
        $const = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Const_($constantName, $expr);
        $classConst = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags = \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
        $this->mirrorComments($classConst, $variable);
        $constantType = $this->getStaticType($classConst->consts[0]->value);
        $this->varAnnotationManipulator->decorateNodeWithType($classConst, $constantType);
        return $classConst;
    }
    private function replaceVariableWithClassConstFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, string $variableName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $constantName = $this->getName($classConst);
        if ($constantName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->traverseNodesWithCallable($classMethod, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($variableName, $constantName) : ?ClassConstFetch {
            if (!$this->isVariableName($node, $variableName)) {
                return null;
            }
            // replace with constant fetch
            $classConstFetch = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('self'), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($constantName));
            // needed later
            $classConstFetch->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME));
            return $classConstFetch;
        });
    }
    private function createConstantNameFromVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : string
    {
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $constantName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($variableName);
        return \strtoupper($constantName);
    }
}
