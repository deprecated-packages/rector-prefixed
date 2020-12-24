<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/u5pes
 * @see https://github.com/gueff/blogimus/commit/04086a10320595470efe446c7ddd90e602aa7228
 * @see https://github.com/pxgamer/youtube-dl-php/commit/83cb32b8b36844f2e39f82a862a5ab73da77b608
 * @see \Rector\Php72\Tests\Rector\FuncCall\ParseStrWithResultArgumentRector\ParseStrWithResultArgumentRectorTest
 */
final class ParseStrWithResultArgumentRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use $result argument in parse_str() function', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
parse_str($this->query);
$data = get_defined_vars();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
parse_str($this->query, $result);
$data = $result;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node, 'parse_str')) {
            return null;
        }
        if (isset($node->args[1])) {
            return null;
        }
        $resultVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('result');
        $node->args[1] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($resultVariable);
        $expression = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression === null) {
            return null;
        }
        $nextExpression = $expression->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($nextExpression === null) {
            return null;
        }
        $this->traverseNodesWithCallable($nextExpression, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($resultVariable) : ?Variable {
            if ($this->isFuncCallName($node, 'get_defined_vars')) {
                return $resultVariable;
            }
            return null;
        });
        return $node;
    }
}
