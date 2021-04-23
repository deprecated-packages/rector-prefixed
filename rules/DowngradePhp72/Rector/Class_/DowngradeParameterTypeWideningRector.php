<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp72\NodeAnalyzer\ClassLikeWithTraitsClassMethodResolver;
use Rector\DowngradePhp72\NodeAnalyzer\ParamContravariantDetector;
use Rector\DowngradePhp72\NodeAnalyzer\ParentChildClassMethodTypeResolver;
use Rector\DowngradePhp72\PhpDoc\NativeParamToPhpDocDecorator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
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
     * @var ParentChildClassMethodTypeResolver
     */
    private $parentChildClassMethodTypeResolver;
    /**
     * @var NativeParamToPhpDocDecorator
     */
    private $nativeParamToPhpDocDecorator;
    /**
     * @var ParamContravariantDetector
     */
    private $paramContravariantDetector;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\Rector\DowngradePhp72\NodeAnalyzer\ClassLikeWithTraitsClassMethodResolver $classLikeWithTraitsClassMethodResolver, \Rector\DowngradePhp72\NodeAnalyzer\ParentChildClassMethodTypeResolver $parentChildClassMethodTypeResolver, \Rector\DowngradePhp72\PhpDoc\NativeParamToPhpDocDecorator $nativeParamToPhpDocDecorator, \Rector\DowngradePhp72\NodeAnalyzer\ParamContravariantDetector $paramContravariantDetector, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->classLikeWithTraitsClassMethodResolver = $classLikeWithTraitsClassMethodResolver;
        $this->parentChildClassMethodTypeResolver = $parentChildClassMethodTypeResolver;
        $this->nativeParamToPhpDocDecorator = $nativeParamToPhpDocDecorator;
        $this->paramContravariantDetector = $paramContravariantDetector;
        $this->typeFactory = $typeFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type to match the lowest type in whole family tree', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface SomeInterface
{
    public function test(array $input);
}

final class SomeClass implements SomeInterface
{
    public function test($input)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
interface SomeInterface
{
    /**
     * @param mixed[] $input
     */
    public function test($input);
}

final class SomeClass implements SomeInterface
{
    public function test($input)
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        if ($this->isEmptyClassReflection($scope)) {
            return null;
        }
        $hasChanged = \false;
        $classMethods = $this->classLikeWithTraitsClassMethodResolver->resolve($node);
        foreach ($classMethods as $classMethod) {
            if ($this->skipClassMethod($classMethod, $scope)) {
                continue;
            }
            // refactor here
            $this->refactorClassMethod($classMethod, $scope);
            $hasChanged = \true;
        }
        if ($hasChanged) {
            return $node;
        }
        return null;
    }
    /**
     * The topmost class is the source of truth, so we go only down to avoid up/down collission
     */
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Analyser\Scope $scope) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $hasChanged = \false;
        foreach ($classMethod->params as $param) {
            $paramPosition = (int) $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
            // Resolve the types in:
            // - all ancestors + their descendant classes
            // @todo - all implemented interfaces + their implementing classes
            $parameterTypesByParentClassLikes = $this->parentChildClassMethodTypeResolver->resolve($classReflection, $methodName, $paramPosition, $scope);
            $uniqueTypes = $this->typeFactory->uniquateTypes($parameterTypesByParentClassLikes);
            if (\count($uniqueTypes) <= 1) {
                continue;
            }
            $this->removeParamTypeFromMethod($classMethod, $param);
            $hasChanged = \true;
        }
        if ($hasChanged) {
            return $classMethod;
        }
        return null;
    }
    private function removeParamTypeFromMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Param $param) : void
    {
        // It already has no type => nothing to do - check original param, as it could have been removed by this rule
        $originalParam = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if ($originalParam instanceof \PhpParser\Node\Param) {
            if ($originalParam->type === null) {
                return;
            }
        } elseif ($param->type === null) {
            return;
        }
        // Add the current type in the PHPDoc
        $this->nativeParamToPhpDocDecorator->decorate($classMethod, $param);
        $param->type = null;
    }
    private function skipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Analyser\Scope $classScope) : bool
    {
        if ($classMethod->isMagic()) {
            return \true;
        }
        if ($classMethod->params === []) {
            return \true;
        }
        // @todo - check for children too, maybe the type differts there
        return !$this->paramContravariantDetector->hasParentMethod($classMethod, $classScope);
    }
    private function isEmptyClassReflection(\PHPStan\Analyser\Scope $scope) : bool
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \true;
        }
        return \count($classReflection->getAncestors()) === 1;
    }
}
