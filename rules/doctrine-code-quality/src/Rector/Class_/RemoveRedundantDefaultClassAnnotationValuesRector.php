<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrineClassAnalyzer;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator\DoctrineItemDefaultValueManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector\RemoveRedundantDefaultClassAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultClassAnnotationValuesRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineClassAnalyzer
     */
    private $doctrineClassAnalyzer;
    /**
     * @var DoctrineItemDefaultValueManipulator
     */
    private $doctrineItemDefaultValueManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrineClassAnalyzer $doctrineClassAnalyzer, \_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator\DoctrineItemDefaultValueManipulator $doctrineItemDefaultValueManipulator)
    {
        $this->doctrineClassAnalyzer = $doctrineClassAnalyzer;
        $this->doctrineItemDefaultValueManipulator = $doctrineItemDefaultValueManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes redundant default values from Doctrine ORM annotations on class level', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=false)
 */
class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SomeClass
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->doctrineItemDefaultValueManipulator->resetHasModifiedAnnotation();
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            $this->refactorClassAnnotations($node);
        }
        if (!$this->doctrineItemDefaultValueManipulator->hasModifiedAnnotation()) {
            return null;
        }
        return $node;
    }
    private function refactorClassAnnotations(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->refactorEntityAnnotation($class);
    }
    private function refactorEntityAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $entityTagValueNode = $this->doctrineClassAnalyzer->matchDoctrineEntityTagValueNode($class);
        if ($entityTagValueNode === null) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($entityTagValueNode, 'readOnly', \false);
    }
}
