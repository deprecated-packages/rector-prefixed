<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\Lexer\TokenEmulator;

use _PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoperb75b35f52b74\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Lexer\Emulative::PHP_7_4;
    }
    public function getKeywordString() : string
    {
        return 'fn';
    }
    public function getKeywordToken() : int
    {
        return \T_FN;
    }
}
