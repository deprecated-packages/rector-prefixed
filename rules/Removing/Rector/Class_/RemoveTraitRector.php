<?php

declare(strict_types=1);

namespace Rector\Removing\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Trait_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Removing\Rector\Class_\RemoveTraitRector\RemoveTraitRectorTest
 */
final class RemoveTraitRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const TRAITS_TO_REMOVE = 'traits_to_remove';

    /**
     * @var bool
     */
    private $classHasChanged = false;

    /**
     * @var string[]
     */
    private $traitsToRemove = [];

    /**
     * @var ClassManipulator
     */
    private $classManipulator;

    public function __construct(ClassManipulator $classManipulator)
    {
        $this->classManipulator = $classManipulator;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove specific traits from code', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    use SomeTrait;
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
}
CODE_SAMPLE
,
                [
                    self::TRAITS_TO_REMOVE => ['TraitNameToRemove'],
                ]
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class, Trait_::class];
    }

    /**
     * @param Class_|Trait_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $usedTraits = $this->classManipulator->getUsedTraits($node);
        if ($usedTraits === []) {
            return null;
        }

        $this->classHasChanged = false;
        $this->removeTraits($usedTraits);

        // invoke re-print
        if ($this->classHasChanged) {
            $node->setAttribute(AttributeKey::ORIGINAL_NODE, null);
            return $node;
        }

        return null;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->traitsToRemove = $configuration[self::TRAITS_TO_REMOVE] ?? [];
    }

    /**
     * @param Name[] $usedTraits
     * @return void
     */
    private function removeTraits(array $usedTraits)
    {
        foreach ($usedTraits as $usedTrait) {
            foreach ($this->traitsToRemove as $traitToRemove) {
                if (! $this->isName($usedTrait, $traitToRemove)) {
                    continue;
                }

                $this->removeNode($usedTrait);
                $this->classHasChanged = true;
                continue 2;
            }
        }
    }
}
