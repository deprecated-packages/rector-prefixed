<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Lexer;
use _PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative;
/**
 * This Lexer allows Format-perserving AST Transformations.
 * @see https://github.com/nikic/PHP-Parser/issues/344#issuecomment-298162516
 */
final class PhpParserLexerFactory
{
    public function create() : \_PhpScoperb75b35f52b74\PhpParser\Lexer
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'], 'phpVersion' => \PHP_VERSION]);
    }
}
