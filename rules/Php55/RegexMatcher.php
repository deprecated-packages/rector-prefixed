<?php

declare (strict_types=1);
namespace Rector\Php55;

use RectorPrefix20210421\Nette\Utils\Strings;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
final class RegexMatcher
{
    /**
     * @var string
     * @see https://regex101.com/r/Ok4wuE/1
     */
    const LAST_E_REGEX = '#(\\w+)?e(\\w+)?$#';
    /**
     * @var string
     * @see https://regex101.com/r/2NWVwT/1
     */
    const LETTER_SUFFIX_REGEX = '#(?<modifiers>\\w+)$#';
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function resolvePatternExpressionWithoutEIfFound(\PhpParser\Node\Expr $expr)
    {
        if ($expr instanceof \PhpParser\Node\Scalar\String_) {
            $pattern = $this->valueResolver->getValue($expr);
            if (!\is_string($pattern)) {
                return null;
            }
            $delimiter = $pattern[0];
            if (!\is_string($delimiter)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            /** @var string $modifiers */
            $modifiers = \RectorPrefix20210421\Nette\Utils\Strings::after($pattern, $delimiter, -1);
            if (!\RectorPrefix20210421\Nette\Utils\Strings::contains($modifiers, 'e')) {
                return null;
            }
            $patternWithoutE = $this->createPatternWithoutE($pattern, $delimiter, $modifiers);
            return new \PhpParser\Node\Scalar\String_($patternWithoutE);
        }
        if ($expr instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->matchConcat($expr);
        }
        return null;
    }
    private function createPatternWithoutE(string $pattern, string $delimiter, string $modifiers) : string
    {
        $modifiersWithoutE = \RectorPrefix20210421\Nette\Utils\Strings::replace($modifiers, '#e#', '');
        return \RectorPrefix20210421\Nette\Utils\Strings::before($pattern, $delimiter, -1) . $delimiter . $modifiersWithoutE;
    }
    /**
     * @return \PhpParser\Node\Expr|null
     */
    private function matchConcat(\PhpParser\Node\Expr\BinaryOp\Concat $concat)
    {
        $lastItem = $concat->right;
        if (!$lastItem instanceof \PhpParser\Node\Scalar\String_) {
            return null;
        }
        $matches = \RectorPrefix20210421\Nette\Utils\Strings::match($lastItem->value, self::LETTER_SUFFIX_REGEX);
        if (!isset($matches['modifiers'])) {
            return null;
        }
        if (!\RectorPrefix20210421\Nette\Utils\Strings::contains($matches['modifiers'], 'e')) {
            return null;
        }
        // replace last "e" in the code
        $lastItem->value = \RectorPrefix20210421\Nette\Utils\Strings::replace($lastItem->value, self::LAST_E_REGEX, '$1$2');
        return $concat;
    }
}
