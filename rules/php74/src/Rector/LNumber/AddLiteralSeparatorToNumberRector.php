<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php74\Rector\LNumber;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\DNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see https://wiki.php.net/rfc/numeric_literal_separator
 * @see https://github.com/nikic/PHP-Parser/pull/615
 * @see \Rector\Php74\Tests\Rector\LNumber\AddLiteralSeparatorToNumberRector\AddLiteralSeparatorToNumberRectorTest
 * @see https://twitter.com/seldaek/status/1329064983120982022
 *
 * Taking the most generic use case to the account: https://wiki.php.net/rfc/numeric_literal_separator#should_it_be_the_role_of_an_ide_to_group_digits
 * The final check should be done manually
 */
final class AddLiteralSeparatorToNumberRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const LIMIT_VALUE = 'limit_value';
    /**
     * @var int
     */
    private const GROUP_SIZE = 3;
    /**
     * @var int
     */
    private $limitValue = 1000000;
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $limitValue = $configuration[self::LIMIT_VALUE] ?? 1000000;
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::integer($limitValue);
        $this->limitValue = $limitValue;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add "_" as thousands separator in numbers for higher or equals to limitValue config', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $int = 500000;
        $float = 1000500.001;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $int = 500_000;
        $float = 1_000_500.001;
    }
}
CODE_SAMPLE
, [self::LIMIT_VALUE => 1000000])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\DNumber::class];
    }
    /**
     * @param LNumber|DNumber $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::LITERAL_SEPARATOR)) {
            return null;
        }
        $numericValueAsString = (string) $node->value;
        if ($this->shouldSkip($node, $numericValueAsString)) {
            return null;
        }
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($numericValueAsString, '.')) {
            [$mainPart, $decimalPart] = \explode('.', $numericValueAsString);
            $chunks = $this->strSplitNegative($mainPart, self::GROUP_SIZE);
            $literalSeparatedNumber = \implode('_', $chunks) . '.' . $decimalPart;
        } else {
            $chunks = $this->strSplitNegative($numericValueAsString, self::GROUP_SIZE);
            $literalSeparatedNumber = \implode('_', $chunks);
            // PHP converts: (string) 1000.0 -> "1000"!
            if (\is_float($node->value)) {
                $literalSeparatedNumber .= '.0';
            }
        }
        $node->value = $literalSeparatedNumber;
        return $node;
    }
    /**
     * @param LNumber|DNumber $node
     */
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $numericValueAsString) : bool
    {
        if ($numericValueAsString < $this->limitValue) {
            return \true;
        }
        // already separated
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($numericValueAsString, '_')) {
            return \true;
        }
        $kind = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::KIND);
        if (\in_array($kind, [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber::KIND_BIN, \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber::KIND_OCT, \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber::KIND_HEX], \true)) {
            return \true;
        }
        // e+/e-
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($numericValueAsString, '#e#i')) {
            return \true;
        }
        // too short
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::length($numericValueAsString) <= self::GROUP_SIZE;
    }
    /**
     * @return string[]
     */
    private function strSplitNegative(string $string, int $length) : array
    {
        $inversed = \strrev($string);
        /** @var string[] $chunks */
        $chunks = \str_split($inversed, $length);
        $chunks = \array_reverse($chunks);
        foreach ($chunks as $key => $chunk) {
            $chunks[$key] = \strrev($chunk);
        }
        return $chunks;
    }
}
