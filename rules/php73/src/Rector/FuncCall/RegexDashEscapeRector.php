<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php73\Rector\FuncCall;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Php\Regex\RegexPatternArgumentManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/dRG8U
 * @see \Rector\Php73\Tests\Rector\FuncCall\RegexDashEscapeRector\RegexDashEscapeRectorTest
 */
final class RegexDashEscapeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/YgVJFp/1
     */
    private const LEFT_HAND_UNESCAPED_DASH_REGEX = '#(\\[.*?\\\\(w|s|d))-(?!\\])#i';
    /**
     * @var string
     * @see https://regex101.com/r/TBVme9/1
     */
    private const RIGHT_HAND_UNESCAPED_DASH_REGEX = '#(?<!\\[)-(\\\\(w|s|d).*?)\\]#i';
    /**
     * @var RegexPatternArgumentManipulator
     */
    private $regexPatternArgumentManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Php\Regex\RegexPatternArgumentManipulator $regexPatternArgumentManipulator)
    {
        $this->regexPatternArgumentManipulator = $regexPatternArgumentManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Escape - in some cases', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
preg_match("#[\w-()]#", 'some text');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
preg_match("#[\w\-()]#", 'some text');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param FuncCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $regexArguments = $this->regexPatternArgumentManipulator->matchCallArgumentWithRegexPattern($node);
        if ($regexArguments === []) {
            return null;
        }
        foreach ($regexArguments as $regexArgument) {
            $this->escapeStringNode($regexArgument);
        }
        return $node;
    }
    private function escapeStringNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string) : void
    {
        $stringValue = $string->value;
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($stringValue, self::LEFT_HAND_UNESCAPED_DASH_REGEX)) {
            $string->value = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($stringValue, self::LEFT_HAND_UNESCAPED_DASH_REGEX, '$1\\-');
            // helped needed to skip re-escaping regular expression
            $string->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::IS_REGULAR_PATTERN, \true);
            return;
        }
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($stringValue, self::RIGHT_HAND_UNESCAPED_DASH_REGEX)) {
            $string->value = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($stringValue, self::RIGHT_HAND_UNESCAPED_DASH_REGEX, '\\-$1]');
            // helped needed to skip re-escaping regular expression
            $string->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::IS_REGULAR_PATTERN, \true);
        }
    }
}
