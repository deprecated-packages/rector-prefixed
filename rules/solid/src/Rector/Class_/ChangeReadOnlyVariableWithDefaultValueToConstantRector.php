<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Const_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SOLID\Tests\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector\ChangeReadOnlyVariableWithDefaultValueToConstantRectorTest
 */
final class ChangeReadOnlyVariableWithDefaultValueToConstantRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodAssignManipulator
     */
    private $classMethodAssignManipulator;
    /**
     * @var VarAnnotationManipulator
     */
    private $varAnnotationManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator $classMethodAssignManipulator, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator)
    {
        $this->classMethodAssignManipulator = $classMethodAssignManipulator;
        $this->varAnnotationManipulator = $varAnnotationManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change variable with read only status with default value to constant', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $readOnlyVariableAssigns = $this->collectReadOnlyVariableAssigns($node);
        $readOnlyVariableAssigns = $this->filterOutUniqueNames($readOnlyVariableAssigns);
        if ($readOnlyVariableAssigns === []) {
            return null;
        }
        foreach ($readOnlyVariableAssigns as $readOnlyVariable) {
            $methodName = $readOnlyVariable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if (!\is_string($methodName)) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $classMethod = $node->getMethod($methodName);
            if ($classMethod === null) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->refactorClassMethod($classMethod, $node, $readOnlyVariableAssigns);
        }
        return $node;
    }
    /**
     * @return Assign[]
     */
    private function collectReadOnlyVariableAssigns(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
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
    private function refactorClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $readOnlyVariableAssigns) : void
    {
        foreach ($readOnlyVariableAssigns as $readOnlyVariableAssign) {
            $this->removeNode($readOnlyVariableAssign);
            /** @var Variable|ClassConstFetch $variable */
            $variable = $readOnlyVariableAssign->var;
            // already overridden
            if (!$variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                continue;
            }
            $classConst = $this->createPrivateClassConst($variable, $readOnlyVariableAssign->expr);
            // replace $variable usage in the code with constant
            $this->addConstantToClass($class, $classConst);
            $variableName = $this->getName($variable);
            if ($variableName === null) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->replaceVariableWithClassConstFetch($classMethod, $variableName, $classConst);
        }
    }
    private function isFoundByRefParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $params = $classMethod->getParams();
        foreach ($params as $param) {
            if ($param->byRef) {
                return \true;
            }
        }
        return \false;
    }
    private function createPrivateClassConst(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst
    {
        $constantName = $this->createConstantNameFromVariable($variable);
        $const = new \_PhpScoperb75b35f52b74\PhpParser\Node\Const_($constantName, $expr);
        $classConst = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags = \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
        $this->mirrorComments($classConst, $variable);
        $constantType = $this->getStaticType($classConst->consts[0]->value);
        $this->varAnnotationManipulator->decorateNodeWithType($classConst, $constantType);
        return $classConst;
    }
    private function replaceVariableWithClassConstFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $constantName = $this->getName($classConst);
        if ($constantName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->traverseNodesWithCallable($classMethod, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($variableName, $constantName) : ?ClassConstFetch {
            if (!$this->isVariableName($node, $variableName)) {
                return null;
            }
            // replace with constant fetch
            $classConstFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self'), new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($constantName));
            // needed later
            $classConstFetch->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME));
            return $classConstFetch;
        });
    }
    private function createConstantNameFromVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : string
    {
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $constantName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($variableName);
        return \strtoupper($constantName);
    }
}
