<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\__Package__\Rector\__Category__;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
__Resources__
* @see \Rector\__Package__\Tests\Rector\__Category__\__Name__\__Name__Test
*/
final class __Name__ extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('__Description__', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(__CodeBeforeExample__, __CodeAfterExample__)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return __NodeTypesPhp__;
    }
    /**
     * @param __NodeTypesDoc__ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        // change the node
        return $node;
    }
}
