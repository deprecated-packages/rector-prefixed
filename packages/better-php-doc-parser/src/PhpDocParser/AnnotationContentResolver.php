<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class AnnotationContentResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/D3sbiI/1
     */
    private const MULTILINE_COMENT_ASTERISK_REGEX = '#(\\s+)\\*(\\s+)#m';
    /**
     * @var TokenIteratorFactory
     */
    private $tokenIteratorFactory;
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory $tokenIteratorFactory)
    {
        $this->tokenIteratorFactory = $tokenIteratorFactory;
        $this->privatesAccessor = $privatesAccessor;
    }
    /**
     * Skip all tokens for this annotation, so next annotation can work with tokens after this one
     * Inspired at @see \PHPStan\PhpDocParser\Parser\PhpDocParser::parseText()
     */
    public function resolveFromTokenIterator(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : string
    {
        $annotationContent = '';
        $unclosedOpenedBracketCount = 0;
        while (\true) {
            if ($tokenIterator->currentTokenType() === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES) {
                ++$unclosedOpenedBracketCount;
            }
            if ($tokenIterator->currentTokenType() === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES) {
                --$unclosedOpenedBracketCount;
            }
            if ($unclosedOpenedBracketCount === 0 && $tokenIterator->currentTokenType() === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL) {
                break;
            }
            // remove new line "*"
            $annotationContent = $this->appendPreviousWhitespace($tokenIterator, $annotationContent);
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($tokenIterator->currentTokenValue(), '*')) {
                $tokenValueWithoutAsterisk = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($tokenIterator->currentTokenValue(), '#\\*#', '');
                $annotationContent .= $tokenValueWithoutAsterisk;
            } else {
                $annotationContent .= $tokenIterator->currentTokenValue();
            }
            // this is the end of single-line comment
            if ($tokenIterator->currentTokenType() === \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END) {
                break;
            }
            $tokenIterator->next();
        }
        return $this->cleanMultilineAnnotationContent($annotationContent);
    }
    public function resolveNestedKey(string $annotationContent, string $name) : string
    {
        $start = \false;
        $openedCurlyBracketCount = 0;
        $tokenContents = [];
        $tokenIterator = $this->tokenIteratorFactory->create($annotationContent);
        while (\true) {
            // the end
            if (\in_array($tokenIterator->currentTokenType(), [\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PHPDOC, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END], \true)) {
                break;
            }
            $start = $this->tryStartWithKey($name, $start, $tokenIterator);
            if (!$start) {
                $tokenIterator->next();
                continue;
            }
            $tokenContents[] = $tokenIterator->currentTokenValue();
            // opening bracket {
            if ($tokenIterator->isCurrentTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET)) {
                ++$openedCurlyBracketCount;
            }
            // closing bracket }
            if ($tokenIterator->isCurrentTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
                --$openedCurlyBracketCount;
                // the final one
                if ($openedCurlyBracketCount === 0) {
                    break;
                }
            }
            $tokenIterator->next();
        }
        return \implode('', $tokenContents);
    }
    private function appendPreviousWhitespace(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationContent) : string
    {
        // is space?
        if (!$tokenIterator->isPrecededByHorizontalWhitespace()) {
            return $annotationContent;
        }
        $tokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $currentIndex = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
        if (!isset($tokens[$currentIndex - 1])) {
            return $annotationContent;
        }
        // do not prepend whitespace without any content
        if ($annotationContent === '') {
            return $annotationContent;
        }
        $previousWhitespaceToken = $tokens[$currentIndex - 1];
        // get the space
        return $annotationContent . $previousWhitespaceToken[0];
    }
    private function cleanMultilineAnnotationContent(string $annotationContent) : string
    {
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($annotationContent, self::MULTILINE_COMENT_ASTERISK_REGEX, '$1$3');
    }
    private function tryStartWithKey(string $name, bool $start, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $localTokenIterator) : bool
    {
        if ($start) {
            return \true;
        }
        if ($localTokenIterator->isCurrentTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) && $localTokenIterator->currentTokenValue() === $name) {
            // consume "=" as well
            $localTokenIterator->next();
            $localTokenIterator->tryConsumeTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_EQUAL);
            return \true;
        }
        return \false;
    }
}
