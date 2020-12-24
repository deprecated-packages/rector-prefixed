<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\PropertyToAddCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\NodeAnalyzer\NetteInjectDetector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Adds new private properties to class + to constructor
 */
final class PropertyAddingPostRector extends \_PhpScoperb75b35f52b74\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @var PropertyToAddCollector
     */
    private $propertyToAddCollector;
    /**
     * @var NetteInjectDetector
     */
    private $netteInjectDetector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoperb75b35f52b74\Rector\PostRector\NodeAnalyzer\NetteInjectDetector $netteInjectDetector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector)
    {
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
        $this->propertyToAddCollector = $propertyToAddCollector;
        $this->netteInjectDetector = $netteInjectDetector;
    }
    public function getPriority() : int
    {
        return 900;
    }
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ || $node->isAnonymous()) {
            return null;
        }
        $this->addConstants($node);
        $this->addProperties($node);
        $this->addPropertiesWithoutConstructor($node);
        return $node;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that adds properties', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public $someProperty;
}
CODE_SAMPLE
)]);
    }
    private function addConstants(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $constants = $this->propertyToAddCollector->getConstantsByClass($class);
        foreach ($constants as $constantName => $nodeConst) {
            $this->classInsertManipulator->addConstantToClass($class, $constantName, $nodeConst);
        }
    }
    private function addProperties(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $properties = $this->propertyToAddCollector->getPropertiesByClass($class);
        $isNetteInjectPreferred = $this->netteInjectDetector->isNetteInjectPreferred($class);
        foreach ($properties as $propertyName => $propertyType) {
            if (!$isNetteInjectPreferred) {
                $this->classDependencyManipulator->addConstructorDependency($class, $propertyName, $propertyType);
            } else {
                $this->classDependencyManipulator->addInjectProperty($class, $propertyName, $propertyType);
            }
        }
    }
    private function addPropertiesWithoutConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $propertiesWithoutConstructor = $this->propertyToAddCollector->getPropertiesWithoutConstructorByClass($class);
        foreach ($propertiesWithoutConstructor as $propertyName => $propertyType) {
            $this->classInsertManipulator->addPropertyToClass($class, $propertyName, $propertyType);
        }
    }
}
