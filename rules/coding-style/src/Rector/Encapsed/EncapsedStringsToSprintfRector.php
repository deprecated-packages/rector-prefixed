<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\Encapsed;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\EncapsedStringPart;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Encapsed\EncapsedStringsToSprintfRector\EncapsedStringsToSprintfRectorTest
 */
final class EncapsedStringsToSprintfRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private $sprintfFormat;
    /**
     * @var Expr[]
     */
    private $argumentVariables = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert enscaped {$string} to more readable sprintf', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\Encapsed::class];
    }
    /**
     * @param Encapsed $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $this->sprintfFormat = '';
        $this->argumentVariables = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\EncapsedStringPart) {
                $this->collectEncapsedStringPart($part);
            } elseif ($part instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr) {
                $this->collectExpr($part);
            }
        }
        return $this->createSprintfFuncCallOrConcat($this->sprintfFormat, $this->argumentVariables);
    }
    private function collectEncapsedStringPart(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\EncapsedStringPart $encapsedStringPart) : void
    {
        $stringValue = $encapsedStringPart->value;
        if ($stringValue === "\n") {
            $this->argumentVariables[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('PHP_EOL'));
            return;
        }
        $this->sprintfFormat .= $stringValue;
    }
    private function collectExpr(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : void
    {
        $this->sprintfFormat .= '%s';
        // remove: ${wrap} → $wrap
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            $expr->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        }
        $this->argumentVariables[] = $expr;
    }
    /**
     * @param Expr[] $argumentVariables
     * @return Concat|FuncCall
     */
    private function createSprintfFuncCallOrConcat(string $string, array $argumentVariables) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        // special case for variable with PHP_EOL
        if ($string === '%s' && \count($argumentVariables) === 2) {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Concat($argumentVariables[0], $argumentVariables[1]);
        }
        $arguments = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($string))];
        foreach ($argumentVariables as $argumentVariable) {
            $arguments[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($argumentVariable);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('sprintf'), $arguments);
    }
}
