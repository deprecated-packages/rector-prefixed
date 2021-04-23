<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\Application\File;
use Rector\DowngradePhp72\NodeAnalyzer\ClassLikeWithTraitsClassMethodResolver;
use Rector\DowngradePhp72\NodeAnalyzer\ParentChildClassMethodTypeResolver;
use Rector\DowngradePhp72\PhpDoc\NativeParamToPhpDocDecorator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://www.php.net/manual/en/migration72.new-features.php#migration72.new-features.param-type-widening
 * @see https://3v4l.org/fOgSE
 *
 * @see \Rector\Tests\DowngradePhp72\Rector\Class_\DowngradeParameterTypeWideningRector\DowngradeParameterTypeWideningRectorTest
 */
final class DowngradeParameterTypeWideningRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassLikeWithTraitsClassMethodResolver
     */
    private $classLikeWithTraitsClassMethodResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var ParentChildClassMethodTypeResolver
     */
    private $parentChildClassMethodTypeResolver;
    /**
     * @var NativeParamToPhpDocDecorator
     */
    private $nativeParamToPhpDocDecorator;
    public function __construct(\Rector\DowngradePhp72\NodeAnalyzer\ClassLikeWithTraitsClassMethodResolver $classLikeWithTraitsClassMethodResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\DowngradePhp72\NodeAnalyzer\ParentChildClassMethodTypeResolver $parentChildClassMethodTypeResolver, \Rector\DowngradePhp72\PhpDoc\NativeParamToPhpDocDecorator $nativeParamToPhpDocDecorator)
    {
        $this->classLikeWithTraitsClassMethodResolver = $classLikeWithTraitsClassMethodResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->parentChildClassMethodTypeResolver = $parentChildClassMethodTypeResolver;
        $this->nativeParamToPhpDocDecorator = $nativeParamToPhpDocDecorator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type to match the lowest type in whole family tree', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface A
{
    public function test(array $input);
}

class C implements A
{
    public function test($input){}
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
interface A
{
    public function test(array $input);
}

class C implements A
{
    public function test(array $input){}
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
     * @param Class_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        if ($this->isEmptyClassReflection($scope)) {
            return null;
        }
        $classMethods = $this->classLikeWithTraitsClassMethodResolver->resolve($node);
        foreach ($classMethods as $classMethod) {
            $this->refactorClassMethod($classMethod, $scope);
        }
        return $node;
    }
    /**
     * The topmost class is the source of truth, so we go only down to avoid up/down collission
     * @return void
     */
    private function refactorParamForSelfAndSiblings(\PhpParser\Node\Stmt\ClassMethod $classMethod, int $position, \PHPStan\Analyser\Scope $scope)
    {
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($class === null) {
            return;
        }
        $className = $this->getName($class);
        if ($className === null) {
            return;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        // Remove the types in:
        // - all ancestors + their descendant classes
        // - all implemented interfaces + their implementing classes
        $parameterTypesByParentClassLikes = $this->parentChildClassMethodTypeResolver->resolve($classReflection, $methodName, $position, $scope);
        // skip classes we cannot change
        foreach (\array_keys($parameterTypesByParentClassLikes) as $className) {
            $classLike = $this->nodeRepository->findClassLike($className);
            if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
                return;
            }
        }
        // we need at least 2 types = 2 occurances of same method
        if (\count($parameterTypesByParentClassLikes) <= 1) {
            return;
        }
        $this->refactorParameters($parameterTypesByParentClassLikes, $methodName, $position);
    }
    /**
     * @return void
     */
    private function removeParamTypeFromMethod(\PhpParser\Node\Stmt\ClassLike $classLike, int $position, \PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $classMethodName = $this->getName($classMethod);
        $currentClassMethod = $classLike->getMethod($classMethodName);
        if (!$currentClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        if (!isset($currentClassMethod->params[$position])) {
            return;
        }
        $param = $currentClassMethod->params[$position];
        // It already has no type => nothing to do
        if ($param->type === null) {
            return;
        }
        // Add the current type in the PHPDoc
        $this->nativeParamToPhpDocDecorator->decorate($classMethod, $param);
        // Remove the type
        $param->type = null;
        $param->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        // file from another file
        $file = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE);
        if ($file instanceof \Rector\Core\ValueObject\Application\File) {
            $rectorWithLineChange = new \Rector\ChangesReporting\ValueObject\RectorWithLineChange($this, $param->getLine());
            $file->addRectorClassWithLine($rectorWithLineChange);
        }
    }
    /**
     * @return void
     */
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Analyser\Scope $classScope)
    {
        if ($classMethod->isMagic()) {
            return;
        }
        if ($classMethod->params === []) {
            return;
        }
        foreach (\array_keys($classMethod->params) as $position) {
            $this->refactorParamForSelfAndSiblings($classMethod, (int) $position, $classScope);
        }
    }
    private function isEmptyClassReflection(\PHPStan\Analyser\Scope $scope) : bool
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \true;
        }
        return \count($classReflection->getAncestors()) === 1;
    }
    /**
     * @param array<class-string, Type> $parameterTypesByParentClassLikes
     * @return void
     */
    private function refactorParameters(array $parameterTypesByParentClassLikes, string $methodName, int $paramPosition)
    {
        foreach (\array_keys($parameterTypesByParentClassLikes) as $className) {
            $classLike = $this->nodeRepository->findClassLike($className);
            if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            $classMethod = $classLike->getMethod($methodName);
            if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            $this->removeParamTypeFromMethod($classLike, $paramPosition, $classMethod);
        }
    }
}
