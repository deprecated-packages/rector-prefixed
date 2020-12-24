<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Encapsed;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\EncapsedStringPart;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Encapsed\EncapsedStringsToSprintfRector\EncapsedStringsToSprintfRectorTest
 */
final class EncapsedStringsToSprintfRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private $sprintfFormat;
    /**
     * @var Expr[]
     */
    private $argumentVariables = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert enscaped {$string} to more readable sprintf', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(string $format)
    {
        return "Unsupported format {$format}";
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(string $format)
    {
        return sprintf('Unsupported format %s', $format);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed::class];
    }
    /**
     * @param Encapsed $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $this->sprintfFormat = '';
        $this->argumentVariables = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\EncapsedStringPart) {
                $this->collectEncapsedStringPart($part);
            } elseif ($part instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
                $this->collectExpr($part);
            }
        }
        return $this->createSprintfFuncCallOrConcat($this->sprintfFormat, $this->argumentVariables);
    }
    private function collectEncapsedStringPart(\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\EncapsedStringPart $encapsedStringPart) : void
    {
        $stringValue = $encapsedStringPart->value;
        if ($stringValue === "\n") {
            $this->argumentVariables[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('PHP_EOL'));
            return;
        }
        $this->sprintfFormat .= $stringValue;
    }
    private function collectExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : void
    {
        $this->sprintfFormat .= '%s';
        // remove: ${wrap} → $wrap
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            $expr->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        }
        $this->argumentVariables[] = $expr;
    }
    /**
     * @param Expr[] $argumentVariables
     * @return Concat|FuncCall
     */
    private function createSprintfFuncCallOrConcat(string $string, array $argumentVariables) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        // special case for variable with PHP_EOL
        if ($string === '%s' && \count($argumentVariables) === 2) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat($argumentVariables[0], $argumentVariables[1]);
        }
        $arguments = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($string))];
        foreach ($argumentVariables as $argumentVariable) {
            $arguments[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($argumentVariable);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('sprintf'), $arguments);
    }
}
