<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\__Package__\Rector\__Category__;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
__Resources__
* @see \Rector\__Package__\Tests\Rector\__Category__\__Name__\__Name__Test
*/
final class __Name__ extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('__Description__', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(__CodeBeforeExample__, __CodeAfterExample__)]);
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
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // change the node
        return $node;
    }
}
