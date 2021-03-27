<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Printer;

use RectorPrefix20210327\Nette\Utils\Arrays;
use RectorPrefix20210327\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Lexer\Lexer;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
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
    public function detectOldWhitespaces(\PHPStan\PhpDocParser\Ast\Node $node, array $tokens, \Rector\BetterPhpDocParser\ValueObject\StartAndEnd $startAndEnd) : array
    {
        $oldWhitespaces = [];
        $start = $startAndEnd->getStart();
        for ($i = $start; $i < $startAndEnd->getEnd(); ++$i) {
            /** @var string $tokenValue */
            $tokenValue = $tokens[$i][0];
            if ($tokens[$i][1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
                // give back "\s+\*" as well
                // do not overlap to previous node
                if ($i - 1 > $start && isset($tokens[$i - 1]) && $tokens[$i - 1][1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                    $previousTokenValue = $tokens[$i - 1][0];
                    if (\RectorPrefix20210327\Nette\Utils\Strings::match($previousTokenValue, self::SPACE_BEFORE_ASTERISK_REGEX)) {
                        $tokenValue = $previousTokenValue . $tokenValue;
                    }
                }
                $oldWhitespaces[] = $tokenValue;
                continue;
            }
            // fixes phpdoc parser multiline spaces BC break https://github.com/phpstan/phpdoc-parser/commit/b451b2f27a97c8c288de63db79c2a843727d4326
            if ($tokens[$i][1] === \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                $nextToken = $tokens[$i + 1];
                if ($nextToken[1] !== \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
                    $oldWhitespaces[] = $tokens[$i][0];
                }
            }
            // quoted string with spaces?
            if ($this->isQuotedStringWithSpaces($tokens, $i)) {
                $matches = \RectorPrefix20210327\Nette\Utils\Strings::matchAll($tokenValue, '#\\s+#m');
                if ($matches !== []) {
                    $oldWhitespaces = \array_merge($oldWhitespaces, \RectorPrefix20210327\Nette\Utils\Arrays::flatten($matches));
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
        return \in_array($tokens[$i][1], [\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING, \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING], \true);
    }
}
