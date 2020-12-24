<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer;

use _PhpScopere8e811afab72\Nette\Utils\Arrays;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
final class WhitespaceDetector
{
    /**
     * @var string
     * @see https://regex101.com/r/w7yAt8/1
     */
    private const SPACE_BEFORE_ASTERISK_REGEX = '#\\s+\\*#m';
    /**
     * @param mixed[] $tokens
     * @return string[]
     */
    public function detectOldWhitespaces(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, array $tokens, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\StartAndEnd $startAndEnd) : array
    {
        $oldWhitespaces = [];
        $start = $startAndEnd->getStart();
        // this is needed, because of 1 token taken from tokens and added annotation name: "ORM" + "\X" → "ORM\X"
        // todo, this might be needed to be dynamic, based on taken tokens count (some Collector?)
        if ($node instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface) {
            --$start;
        }
        for ($i = $start; $i < $startAndEnd->getEnd(); ++$i) {
            /** @var string $tokenValue */
            $tokenValue = $tokens[$i][0];
            if ($tokens[$i][1] === \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
                // give back "\s+\*" as well
                // do not overlap to previous node
                if (($node instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface || $node instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface) && $i - 1 > $start && isset($tokens[$i - 1]) && $tokens[$i - 1][1] === \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                    $previousTokenValue = $tokens[$i - 1][0];
                    if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($previousTokenValue, self::SPACE_BEFORE_ASTERISK_REGEX)) {
                        $tokenValue = $previousTokenValue . $tokenValue;
                    }
                }
                $oldWhitespaces[] = $tokenValue;
                continue;
            }
            // quoted string with spaces?
            if ($this->isQuotedStringWithSpaces($tokens, $i)) {
                $matches = \_PhpScopere8e811afab72\Nette\Utils\Strings::matchAll($tokenValue, '#\\s+#m');
                if ($matches !== []) {
                    $oldWhitespaces = \array_merge($oldWhitespaces, \_PhpScopere8e811afab72\Nette\Utils\Arrays::flatten($matches));
                }
            }
        }
        return $oldWhitespaces;
    }
    /**
     * @param mixed[] $tokens
     */
    private function isQuotedStringWithSpaces(array $tokens, int $i) : bool
    {
        return \in_array($tokens[$i][1], [\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING], \true);
    }
}
