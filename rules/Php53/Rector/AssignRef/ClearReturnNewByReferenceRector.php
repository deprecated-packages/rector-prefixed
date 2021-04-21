<?php

declare(strict_types=1);

namespace Rector\Php53\Rector\AssignRef;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignRef;
use PhpParser\Node\Expr\New_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see https://3v4l.org/UJN6H
 * @see \Rector\Tests\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector\ClearReturnNewByReferenceRectorTest
 */
final class ClearReturnNewByReferenceRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove reference from "$assign = &new Value;"',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
$assign = &new Value;
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$assign = new Value;
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [AssignRef::class];
    }

    /**
     * @param AssignRef $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if (! $node->expr instanceof New_) {
            return null;
        }

        return new Assign($node->var, $node->expr);
    }
}
