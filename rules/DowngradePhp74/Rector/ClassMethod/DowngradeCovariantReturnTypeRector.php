<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\UnionType;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\PhpDoc\TagRemover\ReturnTagRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.type-variance
 *
 * @see \Rector\Tests\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector\DowngradeCovariantReturnTypeRectorTest
 */
final class DowngradeCovariantReturnTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var ReturnTagRemover
     */
    private $returnTagRemover;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \RectorPrefix20210408\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller, \Rector\DeadCode\PhpDoc\TagRemover\ReturnTagRemover $returnTagRemover)
    {
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->privatesCaller = $privatesCaller;
        $this->returnTagRemover = $returnTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make method return same type as parent', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ParentType {}
class ChildType extends ParentType {}

class A
{
    public function covariantReturnTypes(): ParentType
    {
    }
}

class B extends A
{
    public function covariantReturnTypes(): ChildType
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ParentType {}
class ChildType extends ParentType {}

class A
{
    public function covariantReturnTypes(): ParentType
    {
    }
}

class B extends A
{
    /**
     * @return ChildType
     */
    public function covariantReturnTypes(): ParentType
    {
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->returnType === null) {
            return null;
        }
        $parentReturnType = $this->resolveDifferentAncestorReturnType($node, $node->returnType);
        if ($parentReturnType instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        // The return type name could either be a classname, without the leading "\",
        // or one among the reserved identifiers ("static", "self", "iterable", etc)
        // To find out which is the case, check if this name exists as a class
        $parentReturnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($parentReturnType);
        if (!$parentReturnTypeNode instanceof \PhpParser\Node) {
            return null;
        }
        // Make it nullable?
        if ($node->returnType instanceof \PhpParser\Node\NullableType && !$parentReturnTypeNode instanceof \PhpParser\Node\NullableType && !$parentReturnTypeNode instanceof \PhpParser\Node\UnionType) {
            $parentReturnTypeNode = new \PhpParser\Node\NullableType($parentReturnTypeNode);
        }
        // skip if type is already set
        if ($this->nodeComparator->areNodesEqual($parentReturnTypeNode, $node->returnType)) {
            return null;
        }
        // Add the docblock before changing the type
        $this->addDocBlockReturn($node);
        $node->returnType = $parentReturnTypeNode;
        return $node;
    }
    /**
     * @param UnionType|NullableType|Name|Node\Identifier $returnTypeNode
     */
    private function resolveDifferentAncestorReturnType(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node $returnTypeNode) : \PHPStan\Type\Type
    {
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            // possibly trait
            return new \PHPStan\Type\MixedType();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return new \PHPStan\Type\MixedType();
        }
        if ($returnTypeNode instanceof \PhpParser\Node\UnionType) {
            return new \PHPStan\Type\MixedType();
        }
        $bareReturnType = $returnTypeNode instanceof \PhpParser\Node\NullableType ? $returnTypeNode->type : $returnTypeNode;
        $returnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($bareReturnType);
        $methodName = $this->getName($classMethod);
        /** @var ClassReflection[] $parentClassesAndInterfaces */
        $parentClassesAndInterfaces = \array_merge($classReflection->getParents(), $classReflection->getInterfaces());
        foreach ($parentClassesAndInterfaces as $parentClassAndInterface) {
            $parentClassAndInterfaceHasMethod = $parentClassAndInterface->hasMethod($methodName);
            if (!$parentClassAndInterfaceHasMethod) {
                continue;
            }
            $classMethodScope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            $parameterMethodReflection = $parentClassAndInterface->getMethod($methodName, $classMethodScope);
            if (!$parameterMethodReflection instanceof \PHPStan\Reflection\Php\PhpMethodReflection) {
                continue;
            }
            /** @var Type $parentReturnType */
            $parentReturnType = $this->privatesCaller->callPrivateMethod($parameterMethodReflection, 'getReturnType', []);
            if ($parentReturnType->equals($returnType)) {
                continue;
            }
            // This is an ancestor class with a different return type
            return $parentReturnType;
        }
        return new \PHPStan\Type\MixedType();
    }
    private function addDocBlockReturn(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        // keep return type if already set one
        if (!$phpDocInfo->getReturnType() instanceof \PHPStan\Type\MixedType) {
            return;
        }
        /** @var Node $returnType */
        $returnType = $classMethod->returnType;
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnType);
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $type);
        $this->returnTagRemover->removeReturnTagIfUseless($phpDocInfo, $classMethod);
    }
}
