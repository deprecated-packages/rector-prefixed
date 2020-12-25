<?php

declare (strict_types=1);
namespace Rector\PostRector\Rector;

use PhpParser\Node;
use Rector\PSR4\Collector\RenamedClassesCollector;
use Rector\Renaming\NodeManipulator\ClassRenamer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ClassRenamingPostRector extends \Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    /**
     * @var ClassRenamer
     */
    private $classRenamer;
    public function __construct(\Rector\Renaming\NodeManipulator\ClassRenamer $classRenamer, \Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->classRenamer = $classRenamer;
    }
    public function getPriority() : int
    {
        // must be run before name importing, so new names are imported
        return 650;
    }
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        if ($oldToNewClasses === []) {
            return $node;
        }
        return $this->classRenamer->renameNode($node, $oldToNewClasses);
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that renames classes', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass = new AnotherClass();
CODE_SAMPLE
)]);
    }
}
