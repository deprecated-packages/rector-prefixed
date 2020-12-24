<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\Rector\Core\Php\Regex\RegexPatternArgumentManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/function.preg-match.php#105924
 *
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\SimplifyRegexPatternRector\SimplifyRegexPatternRectorTest
 */
final class SimplifyRegexPatternRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const COMPLEX_PATTERN_TO_SIMPLE = ['[0-9]' => '\\d', '[a-zA-Z0-9_]' => '\\w', '[A-Za-z0-9_]' => '\\w', '[0-9a-zA-Z_]' => '\\w', '[0-9A-Za-z_]' => '\\w', '[\\r\\n\\t\\f\\v ]' => '\\s'];
    /**
     * @var RegexPatternArgumentManipulator
     */
    private $regexPatternArgumentManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\Regex\RegexPatternArgumentManipulator $regexPatternArgumentManipulator)
    {
        $this->regexPatternArgumentManipulator = $regexPatternArgumentManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify regex pattern to known ranges', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        preg_match('#[a-zA-Z0-9+]#', $value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        preg_match('#[\w\d+]#', $value);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param FuncCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $patterns = $this->regexPatternArgumentManipulator->matchCallArgumentWithRegexPattern($node);
        if ($patterns === []) {
            return null;
        }
        foreach ($patterns as $pattern) {
            foreach (self::COMPLEX_PATTERN_TO_SIMPLE as $complexPattern => $simple) {
                $pattern->value = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($pattern->value, '#' . \preg_quote($complexPattern, '#') . '#', $simple);
            }
        }
        return $node;
    }
}
