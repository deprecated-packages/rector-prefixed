<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php55;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class RegexMatcher
{
    /**
     * @var string
     * @see https://regex101.com/r/Ok4wuE/1
     */
    private const LAST_E_REGEX = '#(\\w+)?e(\\w+)?$#';
    /**
     * @var string
     * @see https://regex101.com/r/2NWVwT/1
     */
    private const LETTER_SUFFIX_REGEX = '#(?<modifiers>\\w+)$#';
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function resolvePatternExpressionWithoutEIfFound(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            $pattern = $this->valueResolver->getValue($expr);
            if (!\is_string($pattern)) {
                return null;
            }
            $delimiter = $pattern[0];
            if (!\is_string($delimiter)) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            /** @var string $modifiers */
            $modifiers = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($pattern, $delimiter, -1);
            if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($modifiers, 'e')) {
                return null;
            }
            $patternWithoutE = $this->createPatternWithoutE($pattern, $delimiter, $modifiers);
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($patternWithoutE);
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->matchConcat($expr);
        }
        return null;
    }
    private function createPatternWithoutE(string $pattern, string $delimiter, string $modifiers) : string
    {
        $modifiersWithoutE = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($modifiers, '#e#', '');
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::before($pattern, $delimiter, -1) . $delimiter . $modifiersWithoutE;
    }
    private function matchConcat(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Concat $concat) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        $lastItem = $concat->right;
        if (!$lastItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $matches = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($lastItem->value, self::LETTER_SUFFIX_REGEX);
        if (!isset($matches['modifiers'])) {
            return null;
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($matches['modifiers'], 'e')) {
            return null;
        }
        // replace last "e" in the code
        $lastItem->value = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($lastItem->value, self::LAST_E_REGEX, '$1$2');
        return $concat;
    }
}
