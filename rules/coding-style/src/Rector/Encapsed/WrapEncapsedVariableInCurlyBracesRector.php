<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Encapsed;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector\WrapEncapsedVariableInCurlyBracesRectorTest
 */
final class WrapEncapsedVariableInCurlyBracesRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap encapsed variables in curly braces', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function run($world)
{
    echo "Hello $world!"
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function run($world)
{
    echo "Hello {$world}!"
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed::class];
    }
    /**
     * @param Encapsed $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $startTokenPos = $node->getStartTokenPos();
        $hasVariableBeenWrapped = \false;
        foreach ($node->parts as $index => $nodePart) {
            if ($nodePart instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                $previousNode = $nodePart->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                $previousNodeEndTokenPosition = $previousNode === null ? $startTokenPos : $previousNode->getEndTokenPos();
                if ($previousNodeEndTokenPosition + 1 === $nodePart->getStartTokenPos()) {
                    $hasVariableBeenWrapped = \true;
                    $node->parts[$index] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($nodePart->name);
                }
            }
        }
        if (!$hasVariableBeenWrapped) {
            return null;
        }
        return $node;
    }
}
