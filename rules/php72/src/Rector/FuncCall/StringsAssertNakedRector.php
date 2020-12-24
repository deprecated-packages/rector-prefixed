<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/lB5fR
 * @see https://github.com/simplesamlphp/simplesamlphp/pull/708/files
 * @see \Rector\Php72\Tests\Rector\FuncCall\StringsAssertNakedRector\StringsAssertNakedRectorTest
 */
final class StringsAssertNakedRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var Parser
     */
    private $parser;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Parser $parser)
    {
        $this->parser = $parser;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('String asserts must be passed directly to assert()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function nakedAssert()
{
    assert('true === true');
    assert("true === true");
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function nakedAssert()
{
    assert(true === true);
    assert(true === true);
}
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
        if (!$this->isName($node, 'assert')) {
            return null;
        }
        if (!$node->args[0]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var String_ $stringNode */
        $stringNode = $node->args[0]->value;
        $phpCode = '<?php ' . $stringNode->value . ';';
        $contentNodes = $this->parser->parse($phpCode);
        if (!isset($contentNodes[0])) {
            return null;
        }
        if (!$contentNodes[0] instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $node->args[0] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($contentNodes[0]->expr);
        return $node;
    }
}
