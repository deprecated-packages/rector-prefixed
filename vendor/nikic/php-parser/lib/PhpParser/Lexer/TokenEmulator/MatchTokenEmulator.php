<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\TokenEmulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Lexer\Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
