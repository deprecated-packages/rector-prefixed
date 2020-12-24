<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionMethod;
use ReflectionNamedType;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/migration74.new-features.php#migration74.new-features.core.type-variance
 *
 * @see \Rector\DowngradePhp74\Tests\Rector\ClassMethod\DowngradeCovariantReturnTypeRector\DowngradeCovariantReturnTypeRectorTest
 */
final class DowngradeCovariantReturnTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make method return same type as parent', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ParentType {}
class ChildType extends ParentType {}

class A
{
    public function covariantReturnTypes(): ParentType
    { /* … */ }
}

class B extends A
{
    public function covariantReturnTypes(): ChildType
    { /* … */ }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ParentType {}
class ChildType extends ParentType {}

class A
{
    public function covariantReturnTypes(): ParentType
    { /* … */ }
}

class B extends A
{
    /**
     * @return ChildType
     */
    public function covariantReturnTypes(): ParentType
    { /* … */ }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->shouldRefactor($node)) {
            return null;
        }
        /** @var string */
        $parentReflectionMethodName = $this->getDifferentReturnTypeNameFromAncestorClass($node);
        // The return type name could either be a classname, without the leading "\",
        // or one among the reserved identifiers ("static", "self", "iterable", etc)
        // To find out which is the case, check if this name exists as a class
        $newType = \_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($parentReflectionMethodName) ? new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($parentReflectionMethodName) : new \_PhpScopere8e811afab72\PhpParser\Node\Name($parentReflectionMethodName);
        // Make it nullable?
        if ($node->returnType instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $newType = new \_PhpScopere8e811afab72\PhpParser\Node\NullableType($newType);
        }
        // Add the docblock before changing the type
        $this->addDocBlockReturn($node);
        $node->returnType = $newType;
        return $node;
    }
    private function shouldRefactor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->getDifferentReturnTypeNameFromAncestorClass($classMethod) !== null;
    }
    private function getDifferentReturnTypeNameFromAncestorClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?string
    {
        /** @var Scope|null $scope */
        $scope = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            // possibly trait
            return null;
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        $nodeReturnType = $classMethod->returnType;
        if ($nodeReturnType === null || $nodeReturnType instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType) {
            return null;
        }
        $nodeReturnTypeName = $this->getName($nodeReturnType instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType ? $nodeReturnType->type : $nodeReturnType);
        /** @var string $methodName */
        $methodName = $this->getName($classMethod->name);
        // Either Ancestor classes or implemented interfaces
        $parentClassNames = \array_merge($classReflection->getParentClassesNames(), \array_map(function (\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $interfaceReflection) : string {
            return $interfaceReflection->getName();
        }, $classReflection->getInterfaces()));
        foreach ($parentClassNames as $parentClassName) {
            if (!\method_exists($parentClassName, $methodName)) {
                continue;
            }
            $parentReflectionMethod = new \ReflectionMethod($parentClassName, $methodName);
            /** @var ReflectionNamedType|null */
            $parentReflectionMethodReturnType = $parentReflectionMethod->getReturnType();
            if ($parentReflectionMethodReturnType === null || $parentReflectionMethodReturnType->getName() === $nodeReturnTypeName) {
                continue;
            }
            // This is an ancestor class with a different return type
            return $parentReflectionMethodReturnType->getName();
        }
        return null;
    }
    private function addDocBlockReturn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        }
        /** @var Node */
        $returnType = $classMethod->returnType;
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnType);
        $phpDocInfo->changeReturnType($type);
    }
}
