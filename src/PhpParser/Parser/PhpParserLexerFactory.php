<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\Lexer;
use _PhpScoper0a2ac50786fa\PhpParser\Lexer\Emulative;
/**
 * This Lexer allows Format-perserving AST Transformations.
 * @see https://github.com/nikic/PHP-Parser/issues/344#issuecomment-298162516
 */
final class PhpParserLexerFactory
{
    public function create() : \_PhpScoper0a2ac50786fa\PhpParser\Lexer
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'], 'phpVersion' => \PHP_VERSION]);
    }
}
