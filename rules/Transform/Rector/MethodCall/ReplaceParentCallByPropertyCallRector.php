<?php

declare(strict_types=1);

namespace Rector\Transform\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\ReplaceParentCallByPropertyCallRectorTest
 */
final class ReplaceParentCallByPropertyCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const PARENT_CALLS_TO_PROPERTIES = 'parent_calls_to_properties';

    /**
     * @var ReplaceParentCallByPropertyCall[]
     */
    private $parentCallToProperties = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Changes method calls in child of specific types to defined property method call', [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(SomeTypeToReplace $someTypeToReplace)
    {
        $someTypeToReplace->someMethodCall();
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(SomeTypeToReplace $someTypeToReplace)
    {
        $this->someProperty->someMethodCall();
    }
}
CODE_SAMPLE
                    ,
                    [
                        self::PARENT_CALLS_TO_PROPERTIES => [
                            new ReplaceParentCallByPropertyCall('SomeTypeToReplace', 'someMethodCall', 'someProperty'),
                        ],
                    ]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        foreach ($this->parentCallToProperties as $parentCallToProperty) {
            if (! $this->isObjectType($node->var, $parentCallToProperty->getObjectType())) {
                continue;
            }

            if (! $this->isName($node->name, $parentCallToProperty->getMethod())) {
                continue;
            }

            $node->var = $this->nodeFactory->createPropertyFetch('this', $parentCallToProperty->getProperty());
            return $node;
        }

        return null;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->parentCallToProperties = $configuration[self::PARENT_CALLS_TO_PROPERTIES] ?? [];
    }
}
