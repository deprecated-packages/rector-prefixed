<?php

declare(strict_types=1);

namespace Rector\Transform\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Transform\Rector\FuncCall\FuncCallToNewRector\FuncCallToNewRectorTest
 */
final class FuncCallToNewRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const FUNCTIONS_TO_NEWS = 'functions_to_news';

    /**
     * @var string[]
     */
    private $functionToNew = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change configured function calls to new Instance', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $array = collection([]);
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $array = new \Collection([]);
    }
}
CODE_SAMPLE
,
                [
                    self::FUNCTIONS_TO_NEWS => [
                        'collection' => ['Collection'],
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
        return [FuncCall::class];
    }

    /**
     * @param FuncCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        foreach ($this->functionToNew as $function => $new) {
            if (! $this->isName($node, $function)) {
                continue;
            }

            return new New_(new FullyQualified($new), $node->args);
        }

        return null;
    }

    /**
     * @param array<string, mixed> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->functionToNew = $configuration[self::FUNCTIONS_TO_NEWS] ?? [];
    }
}
