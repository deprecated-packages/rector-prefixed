<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoper0a6b37af0871\Rector\Renaming\NodeManipulator\ClassRenamer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class ClassRenamingPostRector extends \_PhpScoper0a6b37af0871\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    /**
     * @var ClassRenamer
     */
    private $classRenamer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Renaming\NodeManipulator\ClassRenamer $classRenamer, \_PhpScoper0a6b37af0871\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
        $this->classRenamer = $classRenamer;
    }
    public function getPriority() : int
    {
        // must be run before name importing, so new names are imported
        return 650;
    }
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        if ($oldToNewClasses === []) {
            return $node;
        }
        return $this->classRenamer->renameNode($node, $oldToNewClasses);
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that renames classes', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass = new AnotherClass();
CODE_SAMPLE
)]);
    }
}
