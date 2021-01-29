<?php

declare (strict_types=1);
namespace Rector\Generics\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode;
use PHPStan\Reflection\ClassReflection;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\Generics\NodeType\GenericTypeSpecifier;
use Rector\Generics\Reflection\ClassGenericMethodResolver;
use Rector\Generics\Reflection\ClassMethodAnalyzer;
use Rector\Generics\Reflection\GenericClassReflectionAnalyzer;
use Rector\Generics\ValueObject\GenericChildParentClassReflections;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/phpstan/phpstan/issues/3167
 *
 * @see \Rector\Generics\Tests\Rector\Class_\GenericsPHPStormMethodAnnotationRector\GenericsPHPStormMethodAnnotationRectorTest
 */
final class GenericsPHPStormMethodAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassGenericMethodResolver
     */
    private $classGenericMethodResolver;
    /**
     * @var GenericTypeSpecifier
     */
    private $genericTypeSpecifier;
    /**
     * @var GenericClassReflectionAnalyzer
     */
    private $genericClassReflectionAnalyzer;
    /**
     * @var ClassMethodAnalyzer
     */
    private $classMethodAnalyzer;
    public function __construct(\Rector\Generics\Reflection\ClassGenericMethodResolver $classGenericMethodResolver, \Rector\Generics\NodeType\GenericTypeSpecifier $genericTypeSpecifier, \Rector\Generics\Reflection\GenericClassReflectionAnalyzer $genericClassReflectionAnalyzer, \Rector\Generics\Reflection\ClassMethodAnalyzer $classMethodAnalyzer)
    {
        $this->classGenericMethodResolver = $classGenericMethodResolver;
        $this->genericTypeSpecifier = $genericTypeSpecifier;
        $this->genericClassReflectionAnalyzer = $genericClassReflectionAnalyzer;
        $this->classMethodAnalyzer = $classMethodAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Complete PHPStorm @method annotations, to make it understand the PHPStan/Psalm generics', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/**
 * @template TEntity as object
 */
abstract class AbstractRepository
{
    /**
     * @return TEntity
     */
    public function find($id)
    {
    }
}

/**
 * @template TEntity as SomeObject
 * @extends AbstractRepository<TEntity>
 */
final class AndroidDeviceRepository extends AbstractRepository
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/**
 * @template TEntity as object
 */
abstract class AbstractRepository
{
    /**
     * @return TEntity
     */
    public function find($id)
    {
    }
}

/**
 * @template TEntity as SomeObject
 * @extends AbstractRepository<TEntity>
 * @method SomeObject find($id)
 */
final class AndroidDeviceRepository extends AbstractRepository
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
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
        $genericChildParentClassReflections = $this->genericClassReflectionAnalyzer->resolveChildParent($node);
        if (!$genericChildParentClassReflections instanceof \Rector\Generics\ValueObject\GenericChildParentClassReflections) {
            return null;
        }
        // resolve generic method from parent
        $methodTagValueNodes = $this->classGenericMethodResolver->resolveFromClass($genericChildParentClassReflections->getParentClassReflection());
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $methodTagValueNodes = $this->filterOutExistingClassMethod($methodTagValueNodes, $phpDocInfo, $genericChildParentClassReflections, $scope);
        $this->genericTypeSpecifier->replaceGenericTypesWithSpecificTypes($methodTagValueNodes, $node, $genericChildParentClassReflections->getChildClassReflection());
        foreach ($methodTagValueNodes as $methodTagValueNode) {
            $phpDocInfo->addTagValueNode($methodTagValueNode);
        }
        return $node;
    }
    /**
     * @param MethodTagValueNode[] $methodTagValueNodes
     * @return MethodTagValueNode[]
     */
    private function filterOutExistingClassMethod(array $methodTagValueNodes, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \Rector\Generics\ValueObject\GenericChildParentClassReflections $genericChildParentClassReflections, \PHPStan\Analyser\Scope $scope) : array
    {
        $methodTagValueNodes = $this->filterOutExistingMethodTagValuesNodes($methodTagValueNodes, $phpDocInfo);
        return $this->filterOutImplementedClassMethods($methodTagValueNodes, $genericChildParentClassReflections->getChildClassReflection(), $scope);
    }
    /**
     * @param MethodTagValueNode[] $methodTagValueNodes
     * @return MethodTagValueNode[]
     */
    private function filterOutExistingMethodTagValuesNodes(array $methodTagValueNodes, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : array
    {
        $methodTagNames = $phpDocInfo->getMethodTagNames();
        if ($methodTagNames === []) {
            return $methodTagValueNodes;
        }
        $filteredMethodTagValueNodes = [];
        foreach ($methodTagValueNodes as $methodTagValueNode) {
            if (\in_array($methodTagValueNode->methodName, $methodTagNames, \true)) {
                continue;
            }
            $filteredMethodTagValueNodes[] = $methodTagValueNode;
        }
        return $filteredMethodTagValueNodes;
    }
    /**
     * @param MethodTagValueNode[] $methodTagValueNodes
     * @return MethodTagValueNode[]
     */
    private function filterOutImplementedClassMethods(array $methodTagValueNodes, \PHPStan\Reflection\ClassReflection $classReflection, \PHPStan\Analyser\Scope $scope) : array
    {
        $filteredMethodTagValueNodes = [];
        foreach ($methodTagValueNodes as $methodTagValueNode) {
            $hasClassMethodDirectly = $this->classMethodAnalyzer->hasClassMethodDirectly($classReflection, $methodTagValueNode->methodName, $scope);
            if ($hasClassMethodDirectly) {
                continue;
            }
            $filteredMethodTagValueNodes[] = $methodTagValueNode;
        }
        return $filteredMethodTagValueNodes;
    }
}
