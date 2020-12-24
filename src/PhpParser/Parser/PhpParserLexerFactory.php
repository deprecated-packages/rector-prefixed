<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\Emulative;
/**
 * This Lexer allows Format-perserving AST Transformations.
 * @see https://github.com/nikic/PHP-Parser/issues/344#issuecomment-298162516
 */
final class PhpParserLexerFactory
{
    public function create() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'], 'phpVersion' => \PHP_VERSION]);
    }
}
