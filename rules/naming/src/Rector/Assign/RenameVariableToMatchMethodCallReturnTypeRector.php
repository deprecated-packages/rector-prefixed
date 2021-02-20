<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\Rector\AbstractRector;
use Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use Rector\Naming\Guard\BreakingVariableRenameGuard;
use Rector\Naming\Matcher\VariableAndCallAssignMatcher;
use Rector\Naming\Naming\ExpectedNameResolver;
use Rector\Naming\NamingConvention\NamingConventionAnalyzer;
use Rector\Naming\PhpDoc\VarTagValueNodeRenamer;
use Rector\Naming\ValueObject\VariableAndCallAssign;
use Rector\Naming\VariableRenamer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector\RenameVariableToMatchMethodCallReturnTypeRectorTest
 */
final class RenameVariableToMatchMethodCallReturnTypeRector extends \Rector\Core\Rector\AbstractRector
{
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
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    public function __construct(\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer, \Rector\Naming\NamingConvention\NamingConventionAnalyzer $namingConventionAnalyzer, \Rector\Naming\PhpDoc\VarTagValueNodeRenamer $varTagValueNodeRenamer, \Rector\Naming\Matcher\VariableAndCallAssignMatcher $variableAndCallAssignMatcher, \Rector\Naming\VariableRenamer $variableRenamer, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
        $this->variableAndCallAssignMatcher = $variableAndCallAssignMatcher;
        $this->namingConventionAnalyzer = $namingConventionAnalyzer;
        $this->varTagValueNodeRenamer = $varTagValueNodeRenamer;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename variable to match method return type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $variableAndCallAssign = $this->variableAndCallAssignMatcher->match($node);
        if (!$variableAndCallAssign instanceof \Rector\Naming\ValueObject\VariableAndCallAssign) {
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
     * @param FuncCall|StaticCall|MethodCall $callNode
     */
    private function isMultipleCall(\PhpParser\Node $callNode) : bool
    {
        $parentNode = $callNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parentNode) {
            $usedNodes = $this->betterNodeFinder->find($parentNode, function (\PhpParser\Node $node) use($callNode) : bool {
                if (\get_class($callNode) !== \get_class($node)) {
                    return \false;
                }
                /** @var FuncCall|StaticCall|MethodCall $node */
                $passedNode = clone $node;
                /** @var FuncCall|StaticCall|MethodCall $callNode */
                $usedNode = clone $callNode;
                /** @var FuncCall|StaticCall|MethodCall $passedNode */
                $passedNode->args = [];
                /** @var FuncCall|StaticCall|MethodCall $usedNode */
                $usedNode->args = [];
                return $this->nodeComparator->areNodesEqual($passedNode, $usedNode);
            });
            if (\count($usedNodes) > 1) {
                return \true;
            }
            $parentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        return \false;
    }
    private function shouldSkip(\Rector\Naming\ValueObject\VariableAndCallAssign $variableAndCallAssign, string $expectedName) : bool
    {
        if ($this->namingConventionAnalyzer->isCallMatchingVariableName($variableAndCallAssign->getCall(), $variableAndCallAssign->getVariableName(), $expectedName)) {
            return \true;
        }
        if ($this->isClassTypeWithChildren($variableAndCallAssign->getCall())) {
            return \true;
        }
        return $this->breakingVariableRenameGuard->shouldSkipVariable($variableAndCallAssign->getVariableName(), $expectedName, $variableAndCallAssign->getFunctionLike(), $variableAndCallAssign->getVariable());
    }
    private function renameVariable(\Rector\Naming\ValueObject\VariableAndCallAssign $variableAndCallAssign, string $expectedName) : void
    {
        $assign = $variableAndCallAssign->getAssign();
        $assignPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($assign);
        $this->varTagValueNodeRenamer->renameAssignVarTagVariableName($assignPhpDocInfo, $variableAndCallAssign->getVariableName(), $expectedName);
        $this->variableRenamer->renameVariableInFunctionLike($variableAndCallAssign->getFunctionLike(), $variableAndCallAssign->getAssign(), $variableAndCallAssign->getVariableName(), $expectedName);
    }
    /**
     * @param StaticCall|MethodCall|FuncCall $expr
     */
    private function isClassTypeWithChildren(\PhpParser\Node\Expr $expr) : bool
    {
        $callStaticType = $this->getStaticType($expr);
        $callStaticType = $this->typeUnwrapper->unwrapNullableType($callStaticType);
        if (!$callStaticType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (\is_a($callStaticType->getClassName(), \PhpParser\Node\Stmt\ClassLike::class, \true)) {
            return \false;
        }
        return $this->familyRelationsAnalyzer->isParentClass($callStaticType->getClassName());
    }
}
