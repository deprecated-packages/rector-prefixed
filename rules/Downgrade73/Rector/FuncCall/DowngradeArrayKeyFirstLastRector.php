<?php

declare(strict_types=1);

namespace Rector\Downgrade73\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see https://wiki.php.net/rfc/array_key_first_last
 *
 * @see \Rector\Tests\Downgrade73\Rector\FuncCall\DowngradeArrayKeyFirstLastRector\DowngradeArrayKeyFirstLastRectorTest
 */
final class DowngradeArrayKeyFirstLastRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Downgrade array_key_first() and array_key_last() functions', [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $firstItemKey = array_key_first($items);
    }
}
CODE_SAMPLE

                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        reset($items);
        $firstItemKey = key($items);
    }
}
CODE_SAMPLE

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
        if ($this->isName($node, 'array_key_first')) {
            return $this->refactorArrayKeyFirst($node);
        }

        if ($this->isName($node, 'array_key_last')) {
            return $this->refactorArrayKeyLast($node);
        }

        return null;
    }

    private function refactorArrayKeyFirst(FuncCall $funcCall): FuncCall
    {
        $array = $funcCall->args[0]->value;
        $resetFuncCall = $this->nodeFactory->createFuncCall('reset', [$array]);
        $this->addNodeBeforeNode($resetFuncCall, $funcCall);

        $funcCall->name = new Name('key');

        return $funcCall;
    }

    private function refactorArrayKeyLast(FuncCall $funcCall): FuncCall
    {
        $array = $funcCall->args[0]->value;
        $resetFuncCall = $this->nodeFactory->createFuncCall('end', [$array]);
        $this->addNodeBeforeNode($resetFuncCall, $funcCall);

        $funcCall->name = new Name('key');

        return $funcCall;
    }
}
