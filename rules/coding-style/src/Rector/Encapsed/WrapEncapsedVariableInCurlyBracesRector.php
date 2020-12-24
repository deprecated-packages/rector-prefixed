<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Encapsed;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector\WrapEncapsedVariableInCurlyBracesRectorTest
 */
final class WrapEncapsedVariableInCurlyBracesRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap encapsed variables in curly braces', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed::class];
    }
    /**
     * @param Encapsed $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $startTokenPos = $node->getStartTokenPos();
        $hasVariableBeenWrapped = \false;
        foreach ($node->parts as $index => $nodePart) {
            if ($nodePart instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                $previousNode = $nodePart->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
                $previousNodeEndTokenPosition = $previousNode === null ? $startTokenPos : $previousNode->getEndTokenPos();
                if ($previousNodeEndTokenPosition + 1 === $nodePart->getStartTokenPos()) {
                    $hasVariableBeenWrapped = \true;
                    $node->parts[$index] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($nodePart->name);
                }
            }
        }
        if (!$hasVariableBeenWrapped) {
            return null;
        }
        return $node;
    }
}
