<?php

declare(strict_types=1);

namespace Rector\Renaming\Rector\String_;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://github.com/symfony/symfony/pull/35858
 *
 * @see \Rector\Tests\Renaming\Rector\String_\RenameStringRector\RenameStringRectorTest
 */
final class RenameStringRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const STRING_CHANGES = 'string_changes';

    /**
     * @var mixed[]
     */
    private $stringChanges = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change string value', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 'ROLE_PREVIOUS_ADMIN';
    }
}
CODE_SAMPLE
,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 'IS_IMPERSONATOR';
    }
}
CODE_SAMPLE
,
                [
                    self::STRING_CHANGES => [
                        'ROLE_PREVIOUS_ADMIN' => 'IS_IMPERSONATOR',
                    ],
                ]
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [String_::class];
    }

    /**
     * @param String_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        foreach ($this->stringChanges as $oldValue => $newValue) {
            if (! $this->valueResolver->isValue($node, $oldValue)) {
                continue;
            }

            return new String_($newValue);
        }

        return null;
    }

    /**
     * @param mixed[] $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->stringChanges = $configuration[self::STRING_CHANGES] ?? [];
    }
}
