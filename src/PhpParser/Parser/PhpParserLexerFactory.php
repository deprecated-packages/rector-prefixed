<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser;

use _PhpScopere8e811afab72\PhpParser\Lexer;
use _PhpScopere8e811afab72\PhpParser\Lexer\Emulative;
/**
 * This Lexer allows Format-perserving AST Transformations.
 * @see https://github.com/nikic/PHP-Parser/issues/344#issuecomment-298162516
 */
final class PhpParserLexerFactory
{
    public function create() : \_PhpScopere8e811afab72\PhpParser\Lexer
    {
        return new \_PhpScopere8e811afab72\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'], 'phpVersion' => \PHP_VERSION]);
    }
}
