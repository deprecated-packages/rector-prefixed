<?php

declare(strict_types=1);

namespace Rector\Removing\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Removing\Rector\Class_\RemoveInterfacesRector\RemoveInterfacesRectorTest
 */
final class RemoveInterfacesRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const INTERFACES_TO_REMOVE = 'interfaces_to_remove';

    /**
     * @var string[]
     */
    private $interfacesToRemove = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Removes interfaces usage from class.', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class SomeClass implements SomeInterface
{
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
                    self::INTERFACES_TO_REMOVE => ['SomeInterface'],
                ]
            ),
        ]);
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
        if ($node->implements === []) {
            return null;
        }

        foreach ($node->implements as $key => $implement) {
            if ($this->isNames($implement, $this->interfacesToRemove)) {
                unset($node->implements[$key]);
            }
        }

        return $node;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->interfacesToRemove = $configuration[self::INTERFACES_TO_REMOVE] ?? [];
    }
}
