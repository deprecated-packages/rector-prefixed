<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\For_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\For_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\For_\ForRepeatedCountToOwnVariableRector\ForRepeatedCountToOwnVariableRectorTest
 */
final class ForRepeatedCountToOwnVariableRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change count() in for function to own variable', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        for ($i = 5; $i <= count($items); $i++) {
            echo $items[$i];
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $itemsCount = count($items);
        for ($i = 5; $i <= $itemsCount; $i++) {
            echo $items[$i];
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\For_::class];
    }
    /**
     * @param For_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $countInCond = null;
        $variableName = null;
        $forScope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $this->traverseNodesWithCallable($node->cond, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$countInCond, &$variableName, $forScope) : ?Variable {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->isName($node, 'count')) {
                return null;
            }
            $countInCond = $node;
            $variableName = $this->variableNaming->resolveFromFuncCallFirstArgumentWithSuffix($node, 'Count', 'itemsCount', $forScope);
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName);
        });
        if ($countInCond === null || $variableName === null) {
            return null;
        }
        $countAssign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName), $countInCond);
        $this->addNodeBeforeNode($countAssign, $node);
        return $node;
    }
}
