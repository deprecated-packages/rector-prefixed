<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\NodeManipulator\DoctrineItemDefaultValueManipulator;
use Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector\RemoveRedundantDefaultClassAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultClassAnnotationValuesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineItemDefaultValueManipulator
     */
    private $doctrineItemDefaultValueManipulator;
    public function __construct(\Rector\Doctrine\NodeManipulator\DoctrineItemDefaultValueManipulator $doctrineItemDefaultValueManipulator)
    {
        $this->doctrineItemDefaultValueManipulator = $doctrineItemDefaultValueManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes redundant default values from Doctrine ORM annotations on class level', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        $this->refactorClassAnnotations($node);
        return $node;
    }
    private function refactorClassAnnotations(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->refactorEntityAnnotation($class);
    }
    private function refactorEntityAnnotation(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
        $entityTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode::class);
        if (!$entityTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $entityTagValueNode, 'readOnly', \false);
    }
}
