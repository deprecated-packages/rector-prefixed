<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PhpParser\Lexer\TokenEmulator;

use _PhpScopere8e811afab72\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScopere8e811afab72\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Lexer\Emulative::PHP_7_4;
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
