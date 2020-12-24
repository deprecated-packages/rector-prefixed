<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Assign;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard\BreakingVariableRenameGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher\VariableAndCallAssignMatcher;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ExpectedNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\NamingConvention\NamingConventionAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\PhpDoc\VarTagValueNodeRenamer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\RenameVariableToMatchMethodCallReturnTypeRectorTest
 */
final class RenameVariableToMatchMethodCallReturnTypeRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const ALLOWED_PARENT_TYPES = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike::class];
    /**
     * @var ExpectedNameResolver
     */
    private $expectedNameResolver;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var BreakingVariableRenameGuard
     */
    private $breakingVariableRenameGuard;
    /**
     * @var FamilyRelationsAnalyzer
     */
    private $familyRelationsAnalyzer;
    /**
     * @var VariableAndCallAssignMatcher
     */
    private $variableAndCallAssignMatcher;
    /**
     * @var NamingConventionAnalyzer
     */
    private $namingConventionAnalyzer;
    /**
     * @var VarTagValueNodeRenamer
     */
    private $varTagValueNodeRenamer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\NamingConvention\NamingConventionAnalyzer $namingConventionAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\PhpDoc\VarTagValueNodeRenamer $varTagValueNodeRenamer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Matcher\VariableAndCallAssignMatcher $variableAndCallAssignMatcher, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer $variableRenamer)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
        $this->variableAndCallAssignMatcher = $variableAndCallAssignMatcher;
        $this->namingConventionAnalyzer = $namingConventionAnalyzer;
        $this->varTagValueNodeRenamer = $varTagValueNodeRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename variable to match method return type', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = $this->getRunner();
    }

    public function getRunner(): Runner
    {
        return new Runner();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $runner = $this->getRunner();
    }

    public function getRunner(): Runner
    {
        return new Runner();
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        /** @var VariableAndCallAssign|null $variableAndCallAssign */
        $variableAndCallAssign = $this->variableAndCallAssignMatcher->match($node);
        if ($variableAndCallAssign === null) {
            return null;
        }
        $call = $variableAndCallAssign->getCall();
        if ($this->isMultipleCall($call)) {
            return null;
        }
        $expectedName = $this->expectedNameResolver->resolveForCall($call);
        if ($expectedName === null) {
            return null;
        }
        if ($this->isName($node->var, $expectedName)) {
            return null;
        }
        if ($this->shouldSkip($variableAndCallAssign, $expectedName)) {
            return null;
        }
        $this->renameVariable($variableAndCallAssign, $expectedName);
        return $node;
    }
    /**
     * @param FuncCall|StaticCall|MethodCall $node
     */
    private function isMultipleCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parentNode) {
            $countUsed = \count($this->betterNodeFinder->find($parentNode, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $n) use($node) : bool {
                if (\get_class($node) !== \get_class($n)) {
                    return \false;
                }
                /** @var FuncCall|StaticCall|MethodCall $n */
                $passedNode = clone $n;
                /** @var FuncCall|StaticCall|MethodCall $node */
                $usedNode = clone $node;
                /** @var FuncCall|StaticCall|MethodCall $passedNode */
                $passedNode->args = [];
                /** @var FuncCall|StaticCall|MethodCall $usedNode */
                $usedNode->args = [];
                return $this->areNodesEqual($passedNode, $usedNode);
            }));
            if ($countUsed > 1) {
                return \true;
            }
            $parentNode = $parentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return \false;
    }
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallAssign $variableAndCallAssign, string $expectedName) : bool
    {
        if ($this->namingConventionAnalyzer->isCallMatchingVariableName($variableAndCallAssign->getCall(), $variableAndCallAssign->getVariableName(), $expectedName)) {
            return \true;
        }
        if ($this->isClassTypeWithChildren($variableAndCallAssign->getCall())) {
            return \true;
        }
        return $this->breakingVariableRenameGuard->shouldSkipVariable($variableAndCallAssign->getVariableName(), $expectedName, $variableAndCallAssign->getFunctionLike(), $variableAndCallAssign->getVariable());
    }
    private function renameVariable(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\VariableAndCallAssign $variableAndCallAssign, string $expectedName) : void
    {
        $this->varTagValueNodeRenamer->renameAssignVarTagVariableName($variableAndCallAssign->getAssign(), $variableAndCallAssign->getVariableName(), $expectedName);
        $this->variableRenamer->renameVariableInFunctionLike($variableAndCallAssign->getFunctionLike(), $variableAndCallAssign->getAssign(), $variableAndCallAssign->getVariableName(), $expectedName);
    }
    /**
     * @param StaticCall|MethodCall|FuncCall $expr
     */
    private function isClassTypeWithChildren(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        $callStaticType = $this->getStaticType($expr);
        $callStaticType = $this->typeUnwrapper->unwrapNullableType($callStaticType);
        if (!$callStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (\in_array($callStaticType->getClassName(), self::ALLOWED_PARENT_TYPES, \true)) {
            return \false;
        }
        return $this->familyRelationsAnalyzer->isParentClass($callStaticType->getClassName());
    }
}
