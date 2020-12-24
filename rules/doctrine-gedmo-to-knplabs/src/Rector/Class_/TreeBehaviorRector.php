<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/tree.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/tree.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TreeBehaviorRector\TreeBehaviorRectorTest
 */
final class TreeBehaviorRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Tree from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 */
class SomeClass
{
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * @var int
     */
    private $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     * @var int
     */
    private $rgt;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     * @var int
     */
    private $lvl;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     * @var Category
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @var Category
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @var Category[]|Collection
     */
    private $children;

    public function getRoot(): self
    {
        return $this->root;
    }

    public function setParent(self $category): void
    {
        $this->parent = $category;
    }

    public function getParent(): self
    {
        return $this->parent;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Knp\DoctrineBehaviors\Contract\Entity\TreeNodeInterface;
use Knp\DoctrineBehaviors\Model\Tree\TreeNodeTrait;

class SomeClass implements TreeNodeInterface
{
    use TreeNodeTrait;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $classPhpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($classPhpDocInfo === null) {
            return null;
        }
        $hasTypeTreeTagValueNode = $classPhpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode::class);
        if (!$hasTypeTreeTagValueNode) {
            return null;
        }
        // we're in a tree entity
        $classPhpDocInfo->removeByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeTagValueNode::class);
        $node->implements[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface');
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait');
        // remove all tree-related properties and their getters and setters - it's handled by behavior trait
        $removedPropertyNames = [];
        foreach ($node->getProperties() as $property) {
            $propertyPhpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDocInfo === null) {
                continue;
            }
            if (!$this->shouldRemoveProperty($propertyPhpDocInfo)) {
                continue;
            }
            $removedPropertyNames[] = $this->getName($property);
            $this->removeNode($property);
        }
        $this->removeClassMethodsForProperties($node, $removedPropertyNames);
        return $node;
    }
    private function shouldRemoveProperty(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : bool
    {
        if ($phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLeftTagValueNode::class)) {
            return \true;
        }
        if ($phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRightTagValueNode::class)) {
            return \true;
        }
        if ($phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeRootTagValueNode::class)) {
            return \true;
        }
        if ($phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeParentTagValueNode::class)) {
            return \true;
        }
        return $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TreeLevelTagValueNode::class);
    }
    /**
     * @param string[] $removedPropertyNames
     */
    private function removeClassMethodsForProperties(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $removedPropertyNames) : void
    {
        foreach ($removedPropertyNames as $removedPropertyName) {
            foreach ($class->getMethods() as $classMethod) {
                if ($this->isName($classMethod, 'get' . \ucfirst($removedPropertyName))) {
                    $this->removeNode($classMethod);
                }
                if ($this->isName($classMethod, 'set' . \ucfirst($removedPropertyName))) {
                    $this->removeNode($classMethod);
                }
            }
        }
    }
}
