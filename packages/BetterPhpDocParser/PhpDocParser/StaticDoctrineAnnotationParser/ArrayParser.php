<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser;

use PHPStan\PhpDocParser\Lexer\Lexer;
use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser\ArrayParserTest
 */
final class ArrayParser
{
    /**
     * @var PlainValueParser
     */
    private $plainValueParser;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser\PlainValueParser $plainValueParser)
    {
        $this->plainValueParser = $plainValueParser;
    }
    /**
     * Mimics https://github.com/doctrine/annotations/blob/c66f06b7c83e9a2a7523351a9d5a4b55f885e574/lib/Doctrine/Common/Annotations/DocParser.php#L1305-L1352
     * @return mixed[]
     */
    public function parseCurlyArray(\Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator $tokenIterator) : array
    {
        $values = [];
        // nothing
        if ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
            return [];
        }
        $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET);
        // If the array is empty, stop parsing and return.
        if ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
            $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET);
            return [];
        }
        // first item
        $values[] = $this->resolveArrayItem($tokenIterator);
        // 2nd+ item
        while ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA)) {
            // optional trailing comma
            if ($tokenIterator->isNextTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
                break;
            }
            $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA);
            $values[] = $this->resolveArrayItem($tokenIterator);
            // skip newlines
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        }
        $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        // special case for nested doctrine annotations
        if (!$tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES)) {
            $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET);
        }
        return $this->createArrayFromValues($values);
    }
    /**
     * Mimics https://github.com/doctrine/annotations/blob/c66f06b7c83e9a2a7523351a9d5a4b55f885e574/lib/Doctrine/Common/Annotations/DocParser.php#L1354-L1385
     * @return array<null|mixed, mixed>
     */
    private function resolveArrayItem(\Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator $tokenIterator) : array
    {
        // skip newlines
        $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        if ($tokenIterator->isNextTokenTypes([\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_EQUAL, \PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON])) {
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_EQUAL);
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
            if ($tokenIterator->isNextTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
                $key = $this->plainValueParser->parseValue($tokenIterator);
            } else {
                $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA);
                $key = $this->plainValueParser->parseValue($tokenIterator);
            }
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_EQUAL);
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
            return [$key, $this->plainValueParser->parseValue($tokenIterator)];
        }
        return [null, $this->plainValueParser->parseValue($tokenIterator)];
    }
    /**
     * @param mixed[] $values
     * @return mixed[]
     */
    private function createArrayFromValues(array $values) : array
    {
        $array = [];
        foreach ($values as $value) {
            [$key, $val] = $value;
            if ($key !== null) {
                $array[$key] = $val;
            } else {
                $array[] = $val;
            }
        }
        return $array;
    }
}
