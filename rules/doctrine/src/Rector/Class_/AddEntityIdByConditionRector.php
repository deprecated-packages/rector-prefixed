<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Doctrine\NodeFactory\EntityIdNodeFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Class_\AddEntityIdByConditionRector\AddEntityIdByConditionRectorTest
 */
final class AddEntityIdByConditionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const DETECTED_TRAITS = '$detectedTraits';
    /**
     * @var string[]
     */
    private $detectedTraits = [];
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var EntityIdNodeFactory
     */
    private $entityIdNodeFactory;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScopere8e811afab72\Rector\Doctrine\NodeFactory\EntityIdNodeFactory $entityIdNodeFactory, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classManipulator = $classManipulator;
        $this->entityIdNodeFactory = $entityIdNodeFactory;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add entity id with annotations when meets condition', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    use SomeTrait;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    use SomeTrait;

    /**
      * @ORM\Id
      * @ORM\Column(type="integer")
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     private $id;

    public function getId(): int
    {
        return $this->id;
    }
}
CODE_SAMPLE
, [self::DETECTED_TRAITS => ['_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']])]);
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        $idProperty = $this->entityIdNodeFactory->createIdProperty();
        $this->classInsertManipulator->addAsFirstMethod($node, $idProperty);
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->detectedTraits = $configuration[self::DETECTED_TRAITS] ?? [];
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->isAnonymousClass($class)) {
            return \true;
        }
        if (!$this->isTraitMatch($class)) {
            return \true;
        }
        return (bool) $class->getProperty('id');
    }
    private function isTraitMatch(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $usedTraits = $this->classManipulator->getUsedTraits($class);
        foreach (\array_keys($usedTraits) as $traitName) {
            foreach ($this->detectedTraits as $detectedTrait) {
                if ($traitName === $detectedTrait) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
