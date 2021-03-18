<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NetteInjectTagNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\NetteCodeQuality\Rector\Class_\MoveInjectToExistingConstructorRector\MoveInjectToExistingConstructorRectorTest
 */
final class MoveInjectToExistingConstructorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyUsageAnalyzer
     */
    private $propertyUsageAnalyzer;
    public function __construct(\Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer $propertyUsageAnalyzer)
    {
        $this->propertyUsageAnalyzer = $propertyUsageAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move @inject properties to constructor, if there already is one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var SomeDependency
     * @inject
     */
    public $someDependency;

    /**
     * @var OtherDependency
     */
    private $otherDependency;

    public function __construct(OtherDependency $otherDependency)
    {
        $this->otherDependency = $otherDependency;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var SomeDependency
     */
    private $someDependency;

    /**
     * @var OtherDependency
     */
    private $otherDependency;

    public function __construct(OtherDependency $otherDependency, SomeDependency $someDependency)
    {
        $this->otherDependency = $otherDependency;
        $this->someDependency = $someDependency;
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
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $injectProperties = $this->getInjectProperties($node);
        if ($injectProperties === []) {
            return null;
        }
        $constructClassMethod = $node->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        foreach ($injectProperties as $injectProperty) {
            $this->removeInjectAnnotation($injectProperty);
            $this->changePropertyVisibility($injectProperty);
            $this->propertyAdder->addPropertyToCollector($injectProperty);
            if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION)) {
                $this->removeNode($injectProperty);
            }
        }
        return $node;
    }
    /**
     * @return Property[]
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function getInjectProperties($class) : array
    {
        return \array_filter($class->getProperties(), function (\PhpParser\Node\Stmt\Property $property) : bool {
            return $this->isInjectProperty($property);
        });
    }
    /**
     * @param \PhpParser\Node\Stmt\Property $property
     */
    private function removeInjectAnnotation($property) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $phpDocInfo->removeByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NetteInjectTagNode::class);
    }
    /**
     * @param \PhpParser\Node\Stmt\Property $injectProperty
     */
    private function changePropertyVisibility($injectProperty) : void
    {
        if ($this->propertyUsageAnalyzer->isPropertyFetchedInChildClass($injectProperty)) {
            $this->visibilityManipulator->makeProtected($injectProperty);
        } else {
            $this->visibilityManipulator->makePrivate($injectProperty);
        }
    }
    /**
     * @param \PhpParser\Node\Stmt\Property $property
     */
    private function isInjectProperty($property) : bool
    {
        if (!$property->isPublic()) {
            return \false;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        return $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette\NetteInjectTagNode::class);
    }
}
