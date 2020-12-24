<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\__Package__\Rector\__Category__;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
__Resources__
* @see \Rector\__Package__\Tests\Rector\__Category__\__Name__\__Name__Test
*/
final class __Name__ extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('__Description__', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(__CodeBeforeExample__, __CodeAfterExample__)]);
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
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        // change the node
        return $node;
    }
}
