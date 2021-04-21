<?php

declare(strict_types=1);

namespace Rector\Doctrine\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\NodeManipulator\DoctrineItemDefaultValueManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Doctrine\Tests\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector\RemoveRedundantDefaultClassAnnotationValuesRectorTest
 */
final class RemoveRedundantDefaultClassAnnotationValuesRector extends AbstractRector
{
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
            'Removes redundant default values from Doctrine ORM annotations on class level',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=false)
 */
class SomeClass
{
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SomeClass
{
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
        return [Class_::class];
    }

    /**
     * @param Class_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $this->refactorClassAnnotations($node);

        return $node;
    }

    /**
     * @return void
     */
    private function refactorClassAnnotations(Class_ $class)
    {
        $this->refactorEntityAnnotation($class);
    }

    /**
     * @return void
     */
    private function refactorEntityAnnotation(Class_ $class)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);

        $doctrineTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\ORM\Mapping\Entity');
        if (! $doctrineTagValueNode instanceof DoctrineAnnotationTagValueNode) {
            return;
        }

        $this->doctrineItemDefaultValueManipulator->remove($phpDocInfo, $doctrineTagValueNode, 'readOnly', false);
    }
}
