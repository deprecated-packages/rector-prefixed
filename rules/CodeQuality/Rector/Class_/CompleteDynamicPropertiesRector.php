<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use Rector\CodeQuality\NodeAnalyzer\ClassLikeAnalyzer;
use Rector\CodeQuality\NodeAnalyzer\LocalPropertyAnalyzer;
use Rector\CodeQuality\NodeFactory\MissingPropertiesFactory;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/GL6II
 * @see https://3v4l.org/eTrhZ
 * @see https://3v4l.org/C554W
 *
 * @see \Rector\Tests\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector\CompleteDynamicPropertiesRectorTest
 */
final class CompleteDynamicPropertiesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var MissingPropertiesFactory
     */
    private $missingPropertiesFactory;
    /**
     * @var LocalPropertyAnalyzer
     */
    private $localPropertyAnalyzer;
    /**
     * @var ClassLikeAnalyzer
     */
    private $classLikeAnalyzer;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\CodeQuality\NodeFactory\MissingPropertiesFactory $missingPropertiesFactory, \Rector\CodeQuality\NodeAnalyzer\LocalPropertyAnalyzer $localPropertyAnalyzer, \Rector\CodeQuality\NodeAnalyzer\ClassLikeAnalyzer $classLikeAnalyzer, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->missingPropertiesFactory = $missingPropertiesFactory;
        $this->localPropertyAnalyzer = $localPropertyAnalyzer;
        $this->classLikeAnalyzer = $classLikeAnalyzer;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add missing dynamic properties', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function set()
    {
        $this->value = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int
     */
    public $value;

    public function set()
    {
        $this->value = 5;
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
        if ($this->shouldSkipClass($node)) {
            return null;
        }
        $className = $this->getName($node);
        if ($className === null) {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        // special case for Laravel Collection macro magic
        $fetchedLocalPropertyNameToTypes = $this->localPropertyAnalyzer->resolveFetchedPropertiesToTypesFromClass($node);
        $propertiesToComplete = $this->resolvePropertiesToComplete($node, $fetchedLocalPropertyNameToTypes);
        if ($propertiesToComplete === []) {
            return null;
        }
        $propertiesToComplete = $this->filterOutExistingProperties($classReflection, $propertiesToComplete);
        $newProperties = $this->missingPropertiesFactory->create($fetchedLocalPropertyNameToTypes, $propertiesToComplete);
        $node->stmts = \array_merge($newProperties, $node->stmts);
        return $node;
    }
    private function shouldSkipClass(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->classAnalyzer->isAnonymousClass($class)) {
            return \true;
        }
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return \true;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return \true;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        // properties are accessed via magic, nothing we can do
        if ($classReflection->hasMethod('__set')) {
            return \true;
        }
        return $classReflection->hasMethod('__get');
    }
    /**
     * @param array<string, Type> $fetchedLocalPropertyNameToTypes
     * @return string[]
     */
    private function resolvePropertiesToComplete(\PhpParser\Node\Stmt\Class_ $class, array $fetchedLocalPropertyNameToTypes) : array
    {
        $propertyNames = $this->classLikeAnalyzer->resolvePropertyNames($class);
        /** @var string[] $fetchedLocalPropertyNames */
        $fetchedLocalPropertyNames = \array_keys($fetchedLocalPropertyNameToTypes);
        return \array_diff($fetchedLocalPropertyNames, $propertyNames);
    }
    /**
     * @param string[] $propertiesToComplete
     * @return string[]
     */
    private function filterOutExistingProperties(\PHPStan\Reflection\ClassReflection $classReflection, array $propertiesToComplete) : array
    {
        $missingPropertyNames = [];
        // remove other properties that are accessible from this scope
        foreach ($propertiesToComplete as $propertyToComplete) {
            if ($classReflection->hasProperty($propertyToComplete)) {
                continue;
            }
            $missingPropertyNames[] = $propertyToComplete;
        }
        return $missingPropertyNames;
    }
}
