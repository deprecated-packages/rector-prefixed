<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\NodeManipulator\DoctrineItemDefaultValueManipulator;
use Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\JoinColumnTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\ManyToManyTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\ManyToOneTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\OneToOneTagValueNode;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector\RemoveRedundantDefaultPropertyAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultPropertyAnnotationValuesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ORPHAN_REMOVAL = 'orphanRemoval';
    /**
     * @var string
     */
    private const FETCH = 'fetch';
    /**
     * @var string
     */
    private const LAZY = 'LAZY';
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
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes redundant default values from Doctrine ORM annotations on class property level', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\ManyToOne(targetEntity=Training::class)
     * @ORM\JoinColumn(name="training", unique=false)
     */
    private $training;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\ManyToOne(targetEntity=Training::class)
     * @ORM\JoinColumn(name="training")
     */
    private $training;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->refactorPropertyAnnotations($node);
        return $node;
    }
    private function refactorPropertyAnnotations(\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $this->refactorColumnAnnotation($phpDocInfo);
        $this->refactorGeneratedValueAnnotation($phpDocInfo);
        $this->refactorJoinColumnAnnotation($phpDocInfo);
        $this->refactorManyToManyAnnotation($phpDocInfo);
        $this->refactorManyToOneAnnotation($phpDocInfo);
        $this->refactorOneToManyAnnotation($phpDocInfo);
        $this->refactorOneToOneAnnotation($phpDocInfo);
    }
    private function refactorColumnAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $columnTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode::class);
        if (!$columnTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\ColumnTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $columnTagValueNode, 'nullable', \false);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $columnTagValueNode, 'unique', \false);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $columnTagValueNode, 'precision', 0);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $columnTagValueNode, 'scale', 0);
    }
    private function refactorGeneratedValueAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $generatedValueTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode::class);
        if (!$generatedValueTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $generatedValueTagValueNode, 'strategy', 'AUTO');
    }
    private function refactorJoinColumnAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $joinColumnTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\JoinColumnTagValueNode::class);
        if (!$joinColumnTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\JoinColumnTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $joinColumnTagValueNode, 'nullable', \true);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $joinColumnTagValueNode, 'referencedColumnName', 'id');
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $joinColumnTagValueNode, 'unique', \false);
    }
    private function refactorManyToManyAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $manyToManyTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\ManyToManyTagValueNode::class);
        if (!$manyToManyTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\ManyToManyTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $manyToManyTagValueNode, self::ORPHAN_REMOVAL, \false);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $manyToManyTagValueNode, self::FETCH, self::LAZY);
    }
    private function refactorManyToOneAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $manyToOneTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\ManyToOneTagValueNode::class);
        if (!$manyToOneTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\ManyToOneTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $manyToOneTagValueNode, self::FETCH, self::LAZY);
    }
    private function refactorOneToManyAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $oneToManyTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode::class);
        if (!$oneToManyTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $oneToManyTagValueNode, self::ORPHAN_REMOVAL, \false);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $oneToManyTagValueNode, self::FETCH, self::LAZY);
    }
    private function refactorOneToOneAnnotation(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $oneToOneTagValueNode = $phpDocInfo->getByType(\Rector\Doctrine\PhpDoc\Node\Property_\OneToOneTagValueNode::class);
        if (!$oneToOneTagValueNode instanceof \Rector\Doctrine\PhpDoc\Node\Property_\OneToOneTagValueNode) {
            return;
        }
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $oneToOneTagValueNode, self::ORPHAN_REMOVAL, \false);
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $oneToOneTagValueNode, self::FETCH, self::LAZY);
    }
}
