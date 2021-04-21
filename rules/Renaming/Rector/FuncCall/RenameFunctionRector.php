<?php

declare(strict_types=1);

namespace Rector\Renaming\Rector\FuncCall;

use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Renaming\Rector\FuncCall\RenameFunctionRector\RenameFunctionRectorTest
 */
final class RenameFunctionRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const OLD_FUNCTION_TO_NEW_FUNCTION = 'old_function_to_new_function';

    /**
     * @var array<string, string>
     */
    private $oldFunctionToNewFunction = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Turns defined function call new one.', [
            new ConfiguredCodeSample(
                'view("...", []);',
                'Laravel\Templating\render("...", []);',
                [
                    self::OLD_FUNCTION_TO_NEW_FUNCTION => [
                        'view' => 'Laravel\Templating\render',
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
        foreach ($this->oldFunctionToNewFunction as $oldFunction => $newFunction) {
            if (! $this->isName($node, $oldFunction)) {
                continue;
            }

            $node->name = $this->createName($newFunction);
            return $node;
        }

        return null;
    }

    /**
     * @param mixed[] $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->oldFunctionToNewFunction = $configuration[self::OLD_FUNCTION_TO_NEW_FUNCTION] ?? [];
    }

    private function createName(string $newFunction): Name
    {
        if (Strings::contains($newFunction, '\\')) {
            return new FullyQualified($newFunction);
        }

        return new Name($newFunction);
    }
}
