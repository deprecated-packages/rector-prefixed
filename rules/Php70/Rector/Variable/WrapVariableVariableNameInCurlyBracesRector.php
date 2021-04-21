<?php

declare(strict_types=1);

namespace Rector\Php70\Rector\Variable;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector\WrapVariableVariableNameInCurlyBracesRectorTest
 * @changelog https://www.php.net/manual/en/language.variables.variable.php
 */
final class WrapVariableVariableNameInCurlyBracesRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Ensure variable variables are wrapped in curly braces',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
function run($foo)
{
    global $$foo->bar;
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
function run($foo)
{
    global ${$foo->bar};
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
        return [Variable::class];
    }

    /**
     * @param Variable $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $nodeName = $node->name;

        if (! $nodeName instanceof PropertyFetch && ! $nodeName instanceof Variable) {
            return null;
        }

        if ($node->getEndTokenPos() !== $nodeName->getEndTokenPos()) {
            return null;
        }

        if ($nodeName instanceof PropertyFetch) {
            return new Variable(new PropertyFetch($nodeName->var, $nodeName->name));
        }

        return new Variable(new Variable($nodeName->name));
    }
}
