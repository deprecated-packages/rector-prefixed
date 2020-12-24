<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\ClassLikeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\LocalPropertyAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeFactory\MissingPropertiesFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/GL6II
 * @see https://3v4l.org/eTrhZ
 * @see https://3v4l.org/C554W
 *
 * @see \Rector\CodeQuality\Tests\Rector\Class_\CompleteDynamicPropertiesRector\CompleteDynamicPropertiesRectorTest
 */
final class CompleteDynamicPropertiesRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeFactory\MissingPropertiesFactory $missingPropertiesFactory, \_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\LocalPropertyAnalyzer $localPropertyAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\NodeAnalyzer\ClassLikeAnalyzer $classLikeAnalyzer)
    {
        $this->missingPropertiesFactory = $missingPropertiesFactory;
        $this->localPropertyAnalyzer = $localPropertyAnalyzer;
        $this->classLikeAnalyzer = $classLikeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add missing dynamic properties', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->shouldSkipClass($node)) {
            return null;
        }
        // special case for Laravel Collection macro magic
        $fetchedLocalPropertyNameToTypes = $this->localPropertyAnalyzer->resolveFetchedPropertiesToTypesFromClass($node);
        $propertiesToComplete = $this->resolvePropertiesToComplete($node, $fetchedLocalPropertyNameToTypes);
        if ($propertiesToComplete === []) {
            return null;
        }
        /** @var string $className */
        $className = $this->getName($node);
        $propertiesToComplete = $this->filterOutExistingProperties($className, $propertiesToComplete);
        $newProperties = $this->missingPropertiesFactory->create($fetchedLocalPropertyNameToTypes, $propertiesToComplete);
        $node->stmts = \array_merge($newProperties, (array) $node->stmts);
        return $node;
    }
    private function shouldSkipClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->isNonAnonymousClass($class)) {
            return \true;
        }
        $className = $this->getName($class);
        if ($className === null) {
            return \true;
        }
        // properties are accessed via magic, nothing we can do
        if (\method_exists($className, '__set')) {
            return \true;
        }
        return \method_exists($className, '__get');
    }
    /**
     * @param array<string, Type> $fetchedLocalPropertyNameToTypes
     * @return string[]
     */
    private function resolvePropertiesToComplete(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, array $fetchedLocalPropertyNameToTypes) : array
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
    private function filterOutExistingProperties(string $className, array $propertiesToComplete) : array
    {
        $missingPropertyNames = [];
        // remove other properties that are accessible from this scope
        foreach ($propertiesToComplete as $propertyToComplete) {
            /** @var string $propertyToComplete */
            if (\property_exists($className, $propertyToComplete)) {
                continue;
            }
            $missingPropertyNames[] = $propertyToComplete;
        }
        return $missingPropertyNames;
    }
}
