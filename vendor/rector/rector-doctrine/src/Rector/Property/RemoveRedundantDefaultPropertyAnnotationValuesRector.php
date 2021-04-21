<?php

declare(strict_types=1);

namespace Rector\Doctrine\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\NodeManipulator\DoctrineItemDefaultValueManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Doctrine\Tests\Rector\Property\RemoveRedundantDefaultPropertyAnnotationValuesRector\RemoveRedundantDefaultPropertyAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultPropertyAnnotationValuesRector extends AbstractRector
{
    /**
     * @var string
     */
    const ORPHAN_REMOVAL = 'orphanRemoval';

    /**
     * @var string
     */
    const FETCH = 'fetch';

    /**
     * @var string
     */
    const LAZY = 'LAZY';

    /**
     * @var DoctrineItemDefaultValueManipulator
     */
    private $doctrineItemDefaultValueManipulator;

    public function __construct(DoctrineItemDefaultValueManipulator $doctrineItemDefaultValueManipulator)
    {
        $this->doctrineItemDefaultValueManipulator = $doctrineItemDefaultValueManipulator;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Removes redundant default values from Doctrine ORM annotations on class property level',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
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
                    ,
                    <<<'CODE_SAMPLE'
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
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Property::class];
    }

    /**
     * @param Property $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $this->refactorPropertyAnnotations($node);
        return $node;
    }

    /**
     * @return void
     */
    private function refactorPropertyAnnotations(Property $property)
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

    /**
     * @return void
     */
    private function refactorColumnAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\Column');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'nullable',
            false
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'unique',
            false
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'precision',
            0
        );
        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $doctrineAnnotationTagValueNode, 'scale', 0);
    }

    /**
     * @return void
     */
    private function refactorGeneratedValueAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\GeneratedValue');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'strategy',
            'AUTO'
        );
    }

    /**
     * @return void
     */
    private function refactorJoinColumnAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\JoinColumn');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'nullable',
            true
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'referencedColumnName',
            'id'
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            'unique',
            false
        );
    }

    /**
     * @return void
     */
    private function refactorManyToManyAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\ManyToMany');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::ORPHAN_REMOVAL,
            false
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::FETCH,
            self::LAZY
        );
    }

    /**
     * @return void
     */
    private function refactorManyToOneAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\ManyToOne');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::FETCH,
            self::LAZY
        );
    }

    /**
     * @return void
     */
    private function refactorOneToManyAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\OneToMany');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::ORPHAN_REMOVAL,
            false
        );
        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::FETCH,
            self::LAZY
        );
    }

    /**
     * @return void
     */
    private function refactorOneToOneAnnotation(PhpDocInfo $phpDocInfo)
    {
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\OneToOne');
        if (! $doctrineAnnotationTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::ORPHAN_REMOVAL,
            false
        );

        $this->doctrineItemDefaultValueManipulator->remove(
            $phpDocInfo,
            $doctrineAnnotationTagValueNode,
            self::FETCH,
            self::LAZY
        );
    }
}
