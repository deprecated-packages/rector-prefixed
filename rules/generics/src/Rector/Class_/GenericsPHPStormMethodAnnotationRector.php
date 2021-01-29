<?php

declare (strict_types=1);
namespace Rector\Generics\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\Core\Rector\AbstractRector;
use Rector\Generics\NodeType\GenericTypeSpecifier;
use Rector\Generics\Reflection\ClassGenericMethodResolver;
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
    public function __construct(\Rector\Generics\Reflection\ClassGenericMethodResolver $classGenericMethodResolver, \Rector\Generics\NodeType\GenericTypeSpecifier $genericTypeSpecifier, \Rector\Generics\Reflection\GenericClassReflectionAnalyzer $genericClassReflectionAnalyzer)
    {
        $this->classGenericMethodResolver = $classGenericMethodResolver;
        $this->genericTypeSpecifier = $genericTypeSpecifier;
        $this->genericClassReflectionAnalyzer = $genericClassReflectionAnalyzer;
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
        if ($node->extends === null) {
            return null;
        }
        $genericChildParentClassReflections = $this->resolveGenericChildParentClassReflections($node);
        if (!$genericChildParentClassReflections instanceof \Rector\Generics\ValueObject\GenericChildParentClassReflections) {
            return null;
        }
        // resolve generic method from parent
        $methodTagValueNodes = $this->classGenericMethodResolver->resolveFromClass($genericChildParentClassReflections->getParentClassReflection());
        $this->genericTypeSpecifier->replaceGenericTypesWithSpecificTypes($methodTagValueNodes, $node, $genericChildParentClassReflections->getChildClassReflection());
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        foreach ($methodTagValueNodes as $methodTagValueNode) {
            $phpDocInfo->addTagValueNode($methodTagValueNode);
        }
        return $node;
    }
    private function resolveGenericChildParentClassReflections(\PhpParser\Node\Stmt\Class_ $class) : ?\Rector\Generics\ValueObject\GenericChildParentClassReflections
    {
        $scope = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        if (!$this->genericClassReflectionAnalyzer->isGeneric($classReflection)) {
            return null;
        }
        $parentClassReflection = $classReflection->getParentClass();
        if (!$parentClassReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return null;
        }
        if (!$this->genericClassReflectionAnalyzer->isGeneric($parentClassReflection)) {
            return null;
        }
        return new \Rector\Generics\ValueObject\GenericChildParentClassReflections($classReflection, $parentClassReflection);
    }
}
