<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer;

use _PhpScoper0a6b37af0871\Nette\Utils\Arrays;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
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
    public function detectOldWhitespaces(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node, array $tokens, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\StartAndEnd $startAndEnd) : array
    {
        $oldWhitespaces = [];
        $start = $startAndEnd->getStart();
        // this is needed, because of 1 token taken from tokens and added annotation name: "ORM" + "\X" → "ORM\X"
        // todo, this might be needed to be dynamic, based on taken tokens count (some Collector?)
        if ($node instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface) {
            --$start;
        }
        for ($i = $start; $i < $startAndEnd->getEnd(); ++$i) {
            /** @var string $tokenValue */
            $tokenValue = $tokens[$i][0];
            if ($tokens[$i][1] === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_HORIZONTAL_WS) {
                // give back "\s+\*" as well
                // do not overlap to previous node
                if (($node instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface || $node instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface) && $i - 1 > $start && isset($tokens[$i - 1]) && $tokens[$i - 1][1] === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                    $previousTokenValue = $tokens[$i - 1][0];
                    if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($previousTokenValue, self::SPACE_BEFORE_ASTERISK_REGEX)) {
                        $tokenValue = $previousTokenValue . $tokenValue;
                    }
                }
                $oldWhitespaces[] = $tokenValue;
                continue;
            }
            // quoted string with spaces?
            if ($this->isQuotedStringWithSpaces($tokens, $i)) {
                $matches = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::matchAll($tokenValue, '#\\s+#m');
                if ($matches !== []) {
                    $oldWhitespaces = \array_merge($oldWhitespaces, \_PhpScoper0a6b37af0871\Nette\Utils\Arrays::flatten($matches));
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
        return \in_array($tokens[$i][1], [\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING], \true);
    }
}
