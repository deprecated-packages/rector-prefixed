<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\DoctrineCodeQuality\NodeManipulator\DoctrineItemDefaultValueManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector\RemoveRedundantDefaultClassAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultClassAnnotationValuesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineItemDefaultValueManipulator
     */
    private $doctrineItemDefaultValueManipulator;
    public function __construct(\Rector\DoctrineCodeQuality\NodeManipulator\DoctrineItemDefaultValueManipulator $doctrineItemDefaultValueManipulator)
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
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            $this->refactorClassAnnotations($node);
        }
        return $node;
    }
    private function refactorClassAnnotations(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->refactorEntityAnnotation($class);
    }
    private function refactorEntityAnnotation(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
        $entityTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
        if (!$entityTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $entityTagValueNode, 'readOnly', \false);
    }
}
