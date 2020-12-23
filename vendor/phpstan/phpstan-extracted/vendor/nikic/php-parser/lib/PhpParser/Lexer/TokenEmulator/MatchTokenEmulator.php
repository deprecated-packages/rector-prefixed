<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PhpParser\Lexer\TokenEmulator;

use _PhpScoper0a2ac50786fa\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoper0a2ac50786fa\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Lexer\Emulative::PHP_8_0;
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
