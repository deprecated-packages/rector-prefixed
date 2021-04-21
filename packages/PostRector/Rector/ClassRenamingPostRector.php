<?php

declare(strict_types=1);

namespace Rector\PostRector\Rector;

use PhpParser\Node;
use Rector\PSR4\Collector\RenamedClassesCollector;
use Rector\Renaming\NodeManipulator\ClassRenamer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ClassRenamingPostRector extends AbstractPostRector
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;

    /**
     * @var ClassRenamer
     */
    private $classRenamer;

    public function __construct(ClassRenamer $classRenamer, RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->classRenamer = $classRenamer;
    }

    public function getPriority(): int
    {
        // must be run before name importing, so new names are imported
        return 650;
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function enterNode(Node $node)
    {
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        if ($oldToNewClasses === []) {
            return $node;
        }

        return $this->classRenamer->renameNode($node, $oldToNewClasses);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rename references for classes that were renamed during Rector run', [
            new CodeSample(
                <<<'CODE_SAMPLE'
function (OriginalClass $someClass)
{
}
CODE_SAMPLE
            ,
                <<<'CODE_SAMPLE'
function (RenamedClass $someClass)
{
}
CODE_SAMPLE
            ),
        ]);
    }
}
