<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\Lexer\TokenEmulator;

use _PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoperb75b35f52b74\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative::PHP_8_0;
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
